# Configuration

Connect your OpenAI API key.

```mermaid
graph LR
    A[🔑 Get API Key] --> B[⚙️ Settings]
    B --> C[💾 Save]
    C --> D[✅ Ready!]
    
    style A fill:#6366F1,stroke:#7C90A0,color:#fff
    style B fill:#F59E0B,stroke:#7C90A0,color:#fff
    style C fill:#189AB4,stroke:#7C90A0,color:#fff
    style D fill:#10B981,stroke:#7C90A0,color:#fff
```

## Step 1: Get Your API Key

1. Go to [OpenAI Platform](https://platform.openai.com/api-keys)
2. Click **Create new secret key**
3. Copy the key (starts with `sk-...`)

!!! warning "Keep it Secret"
    Never share your API key publicly.

## Step 2: Add to WordPress

1. Go to **Settings → PraisonAI**
2. Paste your API key
3. Click **Save Changes**

```mermaid
sequenceDiagram
    participant You
    participant WordPress
    participant OpenAI
    
    You->>WordPress: Paste API Key
    WordPress->>WordPress: Store Securely
    WordPress->>OpenAI: Verify Connection
    OpenAI-->>WordPress: Success!
    WordPress-->>You: Ready to chat!
```

## Done!

Your chatbot is ready. [Add it to a page →](../features/shortcode.md)
