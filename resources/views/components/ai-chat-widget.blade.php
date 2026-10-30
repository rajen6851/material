{{--
    Pristo Enterprises - AI Sales Consultant Floating Widget
    100% self-contained styling with zero dependencies on Tailwind build or Vite dev server.
    Ensures 100% guaranteed visibility, luxury gold/navy branding, and rich product cards.
--}}
<style>
    /* Pristo AI Widget Scoped Styles */
    #pristo-ai-fab {
        position: fixed;
        bottom: 92px;
        right: 20px;
        z-index: 99999;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }
    .pristo-ai-pill {
        background: #0d2238;
        color: #dfb771;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(192, 155, 90, 0.4);
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        animation: pristoPulseGlow 2.5s infinite;
        white-space: nowrap;
    }
    @keyframes pristoPulseGlow {
        0%, 100% { transform: translateY(0); box-shadow: 0 4px 16px rgba(0,0,0,0.25); }
        50% { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(192, 155, 90, 0.35); }
    }
    .pristo-ai-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d2238 0%, #1e3a5f 50%, #c09b5a 100%);
        border: 2px solid rgba(255,255,255,0.25);
        cursor: pointer;
        box-shadow: 0 6px 24px rgba(13, 34, 56, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .pristo-ai-btn:hover {
        transform: scale(1.06);
        box-shadow: 0 8px 28px rgba(192, 155, 90, 0.5);
    }
    .pristo-ai-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #10b981;
        border: 2px solid #fff;
    }

    /* Modal Chat Window */
    #pristo-ai-box {
        display: none;
        position: fixed;
        bottom: 160px;
        right: 20px;
        width: 390px;
        max-width: calc(100vw - 32px);
        height: 580px;
        max-height: calc(100vh - 180px);
        background: #0f1c2c;
        border-radius: 20px;
        box-shadow: 0 16px 48px rgba(0,0,0,0.45);
        border: 1px solid rgba(192, 155, 90, 0.35);
        z-index: 100000;
        flex-direction: column;
        overflow: hidden;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }
    @media (max-width: 640px) {
        #pristo-ai-box {
            bottom: 0 !important;
            right: 0 !important;
            width: 100vw !important;
            max-width: 100vw !important;
            height: 90vh !important;
            max-height: 90vh !important;
            border-radius: 24px 24px 0 0 !important;
        }
        #pristo-ai-fab {
            bottom: 86px !important;
        }
    }

    /* Header */
    .pristo-chat-header {
        background: linear-gradient(135deg, #09131e 0%, #0d2238 60%, #173352 100%);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        color: #fff;
        flex-shrink: 0;
    }
    .pristo-chat-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c09b5a, #8c6a2c);
        color: #0d2238;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }
    .pristo-chat-title h4 {
        margin: 0;
        font-size: 13.5px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pristo-chat-title p {
        margin: 2px 0 0;
        font-size: 10.5px;
        color: #94a3b8;
    }
    .pristo-chat-btn-icon {
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 6px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, color 0.2s;
    }
    .pristo-chat-btn-icon:hover {
        background: rgba(255,255,255,0.1);
        color: #ffffff;
    }

    /* Message Body */
    #pristo-chat-logs {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #09131e;
        color: #e2e8f0;
    }
    #pristo-chat-logs::-webkit-scrollbar {
        width: 5px;
    }
    #pristo-chat-logs::-webkit-scrollbar-thumb {
        background: rgba(192, 155, 90, 0.3);
        border-radius: 4px;
    }
    .pristo-msg-row {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .pristo-msg-row.user {
        justify-content: flex-end;
    }
    .pristo-bubble {
        padding: 11px 14px;
        border-radius: 16px;
        font-size: 12.5px;
        line-height: 1.55;
        max-width: 84%;
        word-break: break-word;
    }
    .pristo-bubble.assistant {
        background: #142436;
        color: #e2e8f0;
        border: 1px solid rgba(255,255,255,0.08);
        border-top-left-radius: 4px;
    }
    .pristo-bubble.user {
        background: linear-gradient(135deg, #c09b5a 0%, #ad8543 100%);
        color: #0d2238;
        font-weight: 600;
        border-top-right-radius: 4px;
    }

    /* Suggestion Chips */
    .pristo-chips-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
    }
    .pristo-chip {
        background: rgba(192, 155, 90, 0.12);
        border: 1px solid rgba(192, 155, 90, 0.35);
        color: #dfb771;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pristo-chip:hover {
        background: rgba(192, 155, 90, 0.25);
        border-color: #dfb771;
        transform: translateY(-1px);
    }

    /* Product Cards */
    .pristo-product-card {
        background: #0d1a29;
        border: 1px solid rgba(192, 155, 90, 0.25);
        border-radius: 12px;
        padding: 10px;
        margin-top: 8px;
        display: flex;
        gap: 12px;
        align-items: center;
        transition: border 0.2s;
    }
    .pristo-product-card:hover {
        border-color: rgba(192, 155, 90, 0.6);
    }
    .pristo-prod-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        background: #1a2f47;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .pristo-prod-details {
        flex: 1;
        min-width: 0;
    }
    .pristo-prod-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .pristo-prod-meta {
        font-size: 10px;
        color: #94a3b8;
        margin: 3px 0;
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .pristo-sku-badge {
        background: #1e3a5f;
        color: #dfb771;
        padding: 1px 5px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 9.5px;
    }
    .pristo-prod-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 4px;
    }
    .pristo-prod-price {
        color: #dfb771;
        font-weight: 800;
        font-size: 12.5px;
    }
    .pristo-prod-link {
        background: rgba(192, 155, 90, 0.2);
        color: #ffffff;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s;
    }
    .pristo-prod-link:hover {
        background: #c09b5a;
        color: #0d2238;
    }

    /* Quotation Card */
    .pristo-quote-card {
        background: rgba(192, 155, 90, 0.1);
        border: 1px solid rgba(192, 155, 90, 0.4);
        border-radius: 12px;
        padding: 12px;
        margin-top: 8px;
        color: #dfb771;
        font-size: 11.5px;
    }
    .pristo-quote-card h5 {
        margin: 0 0 6px 0;
        font-size: 12px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Typing Indicator */
    #pristo-typing-row {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        font-size: 11px;
        color: #94a3b8;
        background: #09131e;
    }
    .pristo-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #c09b5a;
        animation: pristoPulseDot 1.4s infinite ease-in-out;
    }
    .pristo-dot:nth-child(2) { animation-delay: 0.2s; }
    .pristo-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes pristoPulseDot {
        0%, 80%, 100% { opacity: 0.3; transform: scale(0.8); }
        40% { opacity: 1; transform: scale(1.2); }
    }

    /* Footer Input */
    .pristo-chat-footer {
        background: #0d1c2c;
        border-top: 1px solid rgba(255,255,255,0.08);
        padding: 10px 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex-shrink: 0;
    }
    .pristo-input-box {
        display: flex;
        align-items: center;
        background: #142436;
        border: 1px solid rgba(192, 155, 90, 0.25);
        border-radius: 12px;
        padding: 4px 6px 4px 12px;
    }
    .pristo-input-box:focus-within {
        border-color: #c09b5a;
        box-shadow: 0 0 0 2px rgba(192, 155, 90, 0.2);
    }
    #pristo-user-input {
        flex: 1;
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 12px;
        outline: none;
        font-family: inherit;
    }
    #pristo-user-input::placeholder {
        color: #64748b;
    }
    .pristo-send-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #c09b5a, #a67c38);
        border: none;
        color: #0d2238;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.2s, transform 0.1s;
    }
    .pristo-send-btn:hover {
        transform: scale(1.05);
    }
    .pristo-footer-sub {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 10px;
        color: #64748b;
        padding: 0 4px;
    }
    .pristo-footer-sub a {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
    }
    .pristo-footer-sub a:hover {
        text-decoration: underline;
    }
</style>

<!-- Floating AI Trigger (Positioned right above WhatsApp in bottom-right) -->
<div id="pristo-ai-fab">
    <div class="pristo-ai-pill" onclick="togglePristoAiWidget()" title="Click to ask AI Sales Assistant">
        <span style="font-size: 13px;">✨</span>
        <span>AI Sales &amp; Quotes</span>
    </div>
    <button id="pristoAiFabBtn" class="pristo-ai-btn" onclick="togglePristoAiWidget()" title="Pristo AI Sales Agent">
        <span class="pristo-ai-badge"></span>
        <svg id="pristoIconChat" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <svg id="pristoIconClose" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<!-- Modal Chat Assistant Window -->
<div id="pristo-ai-box">
    <!-- Header -->
    <div class="pristo-chat-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="pristo-chat-avatar">PR</div>
            <div class="pristo-chat-title">
                <h4>
                    <span>Pristo AI Sales Agent</span>
                    <span style="font-size:9px; background:rgba(192,155,90,0.2); color:#dfb771; padding:1px 5px; border-radius:4px; font-weight:700;">OFFICIAL</span>
                </h4>
                <p>Luxury Tiles &bull; Sanitaryware &bull; Quotations</p>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:4px;">
            <button class="pristo-chat-btn-icon" onclick="resetPristoAiChat()" title="Reset Chat History">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
            <button class="pristo-chat-btn-icon" onclick="togglePristoAiWidget()" title="Close Chat">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Message Stream -->
    <div id="pristo-chat-logs">
        <!-- Greeting Bubble -->
        <div class="pristo-msg-row">
            <div style="width:26px; height:26px; border-radius:50%; background:#c09b5a; color:#0d2238; font-weight:800; display:flex; align-items:center; justify-content:center; font-size:10px; flex-shrink:0;">P</div>
            <div class="pristo-bubble assistant">
                <p style="margin:0 0 6px 0;">👋 Welcome to <strong>Pristo Enterprises</strong>!</p>
                <p style="margin:0 0 8px 0;">I am your official AI Sales Consultant. I can help you search our live catalogue of <strong>750+ luxury vitrified tiles, parking tiles, sanitaryware, and bath fittings</strong>, or prepare a formal quotation draft for your site.</p>
                <div class="pristo-chips-wrap">
                    <button class="pristo-chip" onclick="quickSend('Show me anti-skid parking tiles 400x400')">🚗 Parking Tiles 400x400</button>
                    <button class="pristo-chip" onclick="quickSend('Show me luxury sanitaryware and basins')">🚿 Sanitaryware &amp; Basins</button>
                    <button class="pristo-chip" onclick="quickSend('I need a formal quotation for my project')">📋 Request Quotation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Typing Indicator -->
    <div id="pristo-typing-row">
        <span class="pristo-dot"></span>
        <span class="pristo-dot"></span>
        <span class="pristo-dot"></span>
        <span style="font-style:italic;">Consulting live catalogue...</span>
    </div>

    <!-- Footer Input Bar -->
    <div class="pristo-chat-footer">
        <form onsubmit="pristoSubmitMessage(event)" class="pristo-input-box">
            <input type="text" id="pristo-user-input" placeholder="Ask about tiles, finishes, prices, or quote..." autocomplete="off">
            <button type="submit" class="pristo-send-btn" title="Send Message">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>
        <div class="pristo-footer-sub">
            <span>Verified Live Catalogue</span>
            <a href="https://wa.me/916362346660?text=Hello%20Pristo%20Sales%20Team" target="_blank" rel="noopener">WhatsApp Support: +91 6362346660</a>
        </div>
    </div>
</div>

<script>
    let _pristoIsOpen = false;
    let _pristoSession = localStorage.getItem('pristo_agent_session');
    if (!_pristoSession) {
        _pristoSession = 'sess_' + Math.random().toString(36).substring(2, 12);
        localStorage.setItem('pristo_agent_session', _pristoSession);
    }

    function togglePristoAiWidget() {
        _pristoIsOpen = !_pristoIsOpen;
        const box = document.getElementById('pristo-ai-box');
        const iconChat = document.getElementById('pristoIconChat');
        const iconClose = document.getElementById('pristoIconClose');

        if (_pristoIsOpen) {
            box.style.display = 'flex';
            iconChat.style.display = 'none';
            iconClose.style.display = 'block';
            document.getElementById('pristo-user-input').focus();
        } else {
            box.style.display = 'none';
            iconChat.style.display = 'block';
            iconClose.style.display = 'none';
        }
    }

    function resetPristoAiChat() {
        if (confirm('Start a fresh conversation?')) {
            _pristoSession = 'sess_' + Math.random().toString(36).substring(2, 12);
            localStorage.setItem('pristo_agent_session', _pristoSession);
            document.getElementById('pristo-chat-logs').innerHTML = `
                <div class="pristo-msg-row">
                    <div style="width:26px; height:26px; border-radius:50%; background:#c09b5a; color:#0d2238; font-weight:800; display:flex; align-items:center; justify-content:center; font-size:10px; flex-shrink:0;">P</div>
                    <div class="pristo-bubble assistant">
                        <p style="margin:0;">Conversation restarted. How can I assist you with your tile or sanitaryware project today?</p>
                    </div>
                </div>
            `;
        }
    }

    function quickSend(txt) {
        document.getElementById('pristo-user-input').value = txt;
        pristoSubmitMessage(new Event('submit'));
    }

    async function pristoSubmitMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('pristo-user-input');
        const text = input.value.trim();
        if (!text) return;

        input.value = '';
        addChatRow('user', text);

        const typing = document.getElementById('pristo-typing-row');
        typing.style.display = 'flex';
        scrollPristoLogs();

        try {
            const resp = await fetch('{{ url("/api/ai/chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    message: text,
                    session_id: _pristoSession
                })
            });

            typing.style.display = 'none';

            if (resp.ok) {
                const data = await resp.json();
                renderAssistantResponse(data);
            } else {
                addChatRow('assistant', "I apologize, but our sales assistant service is experiencing high traffic. Please feel free to WhatsApp our sales team at +91 6362346660.");
            }
        } catch (err) {
            typing.style.display = 'none';
            addChatRow('assistant', "We had trouble connecting to the catalog engine. You can also chat directly with our team on WhatsApp at +91 6362346660.");
        }
    }

    function addChatRow(role, text) {
        const logs = document.getElementById('pristo-chat-logs');
        const row = document.createElement('div');
        row.className = 'pristo-msg-row ' + role;

        if (role === 'user') {
            row.innerHTML = `<div class="pristo-bubble user">${escapeTxt(text)}</div>`;
        } else {
            row.innerHTML = `
                <div style="width:26px; height:26px; border-radius:50%; background:#c09b5a; color:#0d2238; font-weight:800; display:flex; align-items:center; justify-content:center; font-size:10px; flex-shrink:0;">P</div>
                <div class="pristo-bubble assistant">${formatMarkdown(text)}</div>
            `;
        }
        logs.appendChild(row);
        scrollPristoLogs();
    }

    function renderAssistantResponse(data) {
        const logs = document.getElementById('pristo-chat-logs');
        const row = document.createElement('div');
        row.className = 'pristo-msg-row';

        let productsHtml = '';
        if (data.products && data.products.length > 0) {
            data.products.forEach(p => {
                productsHtml += `
                    <div class="pristo-product-card">
                        <img src="${p.image_url}" alt="${escapeTxt(p.name)}" class="pristo-prod-img" onerror="this.src='/images/placeholder-product.jpg'">
                        <div class="pristo-prod-details">
                            <h5 class="pristo-prod-title">${escapeTxt(p.name)}</h5>
                            <div class="pristo-prod-meta">
                                <span class="pristo-sku-badge">SKU: ${p.sku}</span>
                                ${p.size ? `<span>&bull; ${p.size}</span>` : ''}
                                ${p.finish ? `<span>&bull; ${p.finish}</span>` : ''}
                            </div>
                            <div class="pristo-prod-foot">
                                <span class="pristo-prod-price">₹${Number(p.price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>
                                <a href="${p.product_url}" target="_blank" class="pristo-prod-link">View &rarr;</a>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        let quoteHtml = '';
        if (data.quotation_draft) {
            const q = data.quotation_draft;
            quoteHtml = `
                <div class="pristo-quote-card">
                    <h5>📝 Quotation Draft #${q.quote_number}</h5>
                    <p style="margin:2px 0;">Grand Total: <strong>₹${Number(q.grand_total).toLocaleString('en-IN', {minimumFractionDigits:2})}</strong> (incl. 18% GST)</p>
                    <p style="margin:2px 0; font-size:10px; color:#94a3b8;">Status: <em>Pending Authorized Human Review</em></p>
                    <p style="margin:4px 0 0; font-size:9.5px; color:#cbd5e1; font-style:italic;">Our sales team inspects and approves every quotation before dispatching to guarantee pricing accuracy.</p>
                </div>
            `;
        }

        let chipsHtml = '';
        if (data.suggested_actions && data.suggested_actions.length > 0) {
            chipsHtml = '<div class="pristo-chips-wrap">';
            data.suggested_actions.forEach(act => {
                chipsHtml += `<button class="pristo-chip" onclick="quickSend('${escapeTxt(act)}')">${escapeTxt(act)}</button>`;
            });
            chipsHtml += '</div>';
        }

        row.innerHTML = `
            <div style="width:26px; height:26px; border-radius:50%; background:#c09b5a; color:#0d2238; font-weight:800; display:flex; align-items:center; justify-content:center; font-size:10px; flex-shrink:0;">P</div>
            <div class="pristo-bubble assistant">
                <div>${formatMarkdown(data.reply)}</div>
                ${productsHtml}
                ${quoteHtml}
                ${chipsHtml}
            </div>
        `;

        logs.appendChild(row);
        scrollPristoLogs();
    }

    function scrollPristoLogs() {
        const logs = document.getElementById('pristo-chat-logs');
        logs.scrollTop = logs.scrollHeight;
    }

    function escapeTxt(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function formatMarkdown(text) {
        if (!text) return '';
        let escaped = escapeTxt(text);
        escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        escaped = escaped.replace(/\n/g, '<br>');
        return escaped;
    }
</script>
