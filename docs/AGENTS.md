# PraisonAI WordPress Plugin - Agent Instructions

Instructions for AI agents working on this project.

---

## 1. Project Structure

```
praisonaiwp/
├── praisonai.php          # Main plugin file (single source of truth)
├── readme.txt             # WordPress.org readme
├── css/                   # Stylesheets
├── js/                    # JavaScript files
├── languages/             # Translations
├── docs/                  # MkDocs documentation
├── assets/                # Plugin directory banners/icons
├── release.sh             # Auto-release script
└── deploy.sh              # Manual SVN deploy
```

---

## 2. Version Management

**Single Source of Truth:** `praisonai.php` line 6

```php
* Version:     1.0.3
```

The `release.sh` script auto-syncs version to `readme.txt`.

---

## 3. Release Process

```mermaid
graph LR
    A[Update Version] --> B[Run release.sh]
    B --> C[Auto Tag]
    C --> D[GitHub Actions]
    D --> E[WordPress.org SVN]
    
    style A fill:#6366F1,stroke:#7C90A0,color:#fff
    style B fill:#F59E0B,stroke:#7C90A0,color:#fff
    style C fill:#189AB4,stroke:#7C90A0,color:#fff
    style D fill:#8B0000,stroke:#7C90A0,color:#fff
    style E fill:#10B981,stroke:#7C90A0,color:#fff
```

**Steps:**
1. Update version in `praisonai.php`
2. Run `./release.sh`
3. GitHub Action deploys to WordPress.org

---

## 4. Key Files

### Main Plugin (`praisonai.php`)

| Function | Purpose |
|----------|---------|
| `praisonai_add_admin_menu()` | Add settings page |
| `praisonai_register_settings()` | Register API key setting |
| `praisonai_chat_shortcode()` | Render `[praisonai_chat]` |
| `praisonai_handle_chat_message()` | AJAX handler for chat |

### JavaScript (`js/praisonai-chat.js`)

Handles:
- Form submission
- AJAX requests to OpenAI
- Response display

### CSS (`css/praisonai-chat.css`)

Styles for:
- `.praisonai-chat-container`
- `.praisonai-chat-history`
- `.praisonai-chat-form`

---

## 5. WordPress Coding Standards

### Required Patterns

```php
// ✅ Direct file access check (MUST BE FIRST)
if (!defined('ABSPATH')) {
    exit;
}

// ✅ Proper enqueuing
wp_enqueue_script('handle', plugin_dir_url(__FILE__) . 'js/file.js');

// ✅ Sanitization
$input = sanitize_text_field(wp_unslash($_POST['field']));

// ✅ Escaping output  
echo esc_html($value);
echo esc_attr($attribute);

// ✅ Nonce verification
check_ajax_referer('praisonai_chat_nonce', 'nonce');
```

### Forbidden Patterns

```php
// ❌ Inline scripts
echo '<script>...</script>';

// ❌ Direct $_POST access
$data = $_POST['field'];

// ❌ Unescaped output
echo $user_input;
```

---

## 6. Documentation Standards

### Style Guide

| Principle | Example |
|-----------|---------|
| **Concise** | "Add chatbot with shortcode" |
| **Visual** | Include mermaid diagram |
| **Beginner-friendly** | Avoid jargon |
| **Actionable** | Show exact steps |

### Every Page Needs

- [ ] Mermaid diagram at top
- [ ] Simple explanation
- [ ] Step-by-step instructions
- [ ] Links to related pages

### MkDocs Location

```
docs/
├── index.md
├── getting-started/
│   ├── installation.md
│   └── configuration.md
├── features/
│   ├── chatbot.md
│   ├── shortcode.md
│   └── api-settings.md
├── guides/
│   ├── customization.md
│   └── troubleshooting.md
└── development/
    └── AGENTS.md
```

---

## 7. Testing Checklist

Before any release:

- [ ] Plugin activates without errors
- [ ] Settings page saves API key
- [ ] Shortcode renders chatbot
- [ ] Chat messages send/receive
- [ ] Works with default theme
- [ ] No JavaScript console errors
- [ ] Mobile responsive

---

## 8. GitHub Workflows

| Workflow | Trigger | Purpose |
|----------|---------|---------|
| `deploy.yml` | Tag push `v*.*.*` | Deploy to WordPress.org |
| `docs.yml` | Push to `docs/` | Build MkDocs to GitHub Pages |

---

## 9. External Services

The plugin uses **OpenAI API**:

- Endpoint: `https://api.openai.com/v1/chat/completions`
- Model: `gpt-3.5-turbo`
- Data sent: User message only
- Must document in `readme.txt`

---

## 10. Quick Commands

```bash
# Release new version
./release.sh

# Manual SVN deploy
./deploy.sh "Commit message"

# Build docs locally
pip install mkdocs mkdocs-material pymdown-extensions
mkdocs serve
```
