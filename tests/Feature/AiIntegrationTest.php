<?php

namespace Tests\Feature;

use App\Models\AiQuotation;
use App\Models\AiQuotationItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AiIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    protected string $secretToken = 'pristo_ai_secure_token_2026';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.database' => 'agentpristo',
            'database.connections.mysql.username' => 'root',
            'database.connections.mysql.password' => '',
            'database.connections.mysql.host' => '127.0.0.1',
        ]);
    }

    public function test_internal_products_rejects_unauthorized_request(): void
    {
        $response = $this->getJson('/api/ai/products-internal');
        $response->assertStatus(401);
    }

    public function test_internal_products_returns_catalogue_with_valid_token(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->secretToken,
        ])->getJson('/api/ai/products-internal?limit=3');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'count',
            'products' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'sku',
                    'mrp',
                    'price',
                    'stock',
                    'image_url',
                    'product_url',
                ]
            ]
        ]);
    }

    public function test_create_draft_quotation_successfully(): void
    {
        $product = Product::first();
        $this->assertNotNull($product, 'At least one product should exist in database.');

        $payload = [
            'channel' => 'website',
            'session_id' => 'test_session_123',
            'customer_name' => 'Vijay Sharma',
            'customer_phone' => '+91 9876543210',
            'customer_email' => 'vijay@example.com',
            'customer_type' => 'homeowner',
            'delivery_address' => 'Indiranagar 100ft Road, Bangalore',
            'pincode' => '560038',
            'customer_notes' => 'Please verify parking tile stock',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_type' => 'box',
                ]
            ],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->secretToken,
        ])->postJson('/api/ai/quotes/draft', $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'message',
            'quote_number',
            'id',
            'subtotal',
            'tax_total',
            'grand_total',
            'status',
        ]);

        $quoteId = $response->json('id');
        $this->assertDatabaseHas('ai_quotations', [
            'id' => $quoteId,
            'customer_phone' => '+91 9876543210',
            'status' => 'draft_pending',
        ]);
    }

    public function test_admin_cannot_send_unapproved_quotation(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'test_admin_security@pristo.in'],
            [
                'name' => 'Security Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        $product = Product::first();
        $quote = AiQuotation::create([
            'quote_number' => AiQuotation::generateQuoteNumber(),
            'channel' => 'website',
            'customer_name' => 'Unapproved Customer',
            'customer_phone' => '+919999988888',
            'delivery_address' => 'Bangalore',
            'pincode' => '560001',
            'subtotal' => 5000,
            'tax_total' => 900,
            'grand_total' => 5000,
            'status' => 'draft_pending', // not approved!
        ]);

        $response = $this->actingAs($admin)
            ->post("/admin/ai-quotes/{$quote->id}/send");

        $response->assertSessionHas('error');
        $this->assertEquals('draft_pending', $quote->fresh()->status);
    }

    public function test_admin_can_approve_quotation_and_set_audit_stamp(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'test_admin_approver@pristo.in'],
            [
                'name' => 'Approver Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        $product = Product::first();
        $quote = AiQuotation::create([
            'quote_number' => AiQuotation::generateQuoteNumber(),
            'channel' => 'website',
            'customer_name' => 'Approval Target Customer',
            'customer_phone' => '+919876543211',
            'delivery_address' => 'Koramangala, Bangalore',
            'pincode' => '560034',
            'subtotal' => 10000,
            'tax_total' => 1800,
            'grand_total' => 10000,
            'status' => 'draft_pending',
        ]);

        AiQuotationItem::create([
            'ai_quotation_id' => $quote->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'sku' => $product->sku,
            'unit_type' => 'box',
            'unit_price' => 1000,
            'quantity' => 10,
            'gst_percent' => 18,
            'total_price' => 10000,
        ]);

        $response = $this->actingAs($admin)
            ->post("/admin/ai-quotes/{$quote->id}/approve", [
                'discount_total' => 500,
                'admin_notes' => 'Applied 500 INR promotional concession',
            ]);

        $response->assertRedirect(route('admin.ai-quotes.show', $quote->id));

        $fresh = $quote->fresh();
        $this->assertEquals('approved', $fresh->status);
        $this->assertEquals($admin->id, $fresh->approved_by_user_id);
        $this->assertNotNull($fresh->approved_at);
        $this->assertEquals(9500, $fresh->grand_total);
    }
}
