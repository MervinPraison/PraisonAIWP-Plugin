# Shortcode

Add the chatbot anywhere with one line.

```mermaid
graph LR
    A[📝 Shortcode] --> B[📄 Page/Post]
    B --> C[💬 Chatbot Appears]
    
    style A fill:#6366F1,stroke:#7C90A0,color:#fff
    style B fill:#F59E0B,stroke:#7C90A0,color:#fff
    style C fill:#10B981,stroke:#7C90A0,color:#fff
```

## The Shortcode

```
[praisonai_chat]
```

That's all you need!

## Where To Add It

```mermaid
graph TB
    SC[Shortcode]
    SC --> P[📄 Pages]
    SC --> A[📰 Posts]
    SC --> W[🧩 Widgets]
    SC --> T[📐 Templates]
    
    style SC fill:#8B0000,stroke:#7C90A0,color:#fff
    style P fill:#6366F1,stroke:#7C90A0,color:#fff
    style A fill:#6366F1,stroke:#7C90A0,color:#fff
    style W fill:#6366F1,stroke:#7C90A0,color:#fff
    style T fill:#6366F1,stroke:#7C90A0,color:#fff
```

| Location | How |
|----------|-----|
| **Page** | Edit page → Add shortcode block |
| **Post** | Edit post → Add shortcode block |
| **Widget** | Appearance → Widgets → Add shortcode |
| **Template** | Use `<?php echo do_shortcode('[praisonai_chat]'); ?>` |

## Example

### In the Block Editor (Gutenberg)

1. Click **+** to add block
2. Search "Shortcode"
3. Paste `[praisonai_chat]`
4. Publish!

### In Classic Editor

Just paste the shortcode in the content area.

## Smart Loading

Scripts only load on pages with the shortcode. Your other pages stay fast! ⚡
