=== PraisonAI ===
Contributors: MervinPraison
Donate link: https://mer.vin/
Tags: ai, chatbot, openai, gpt, chat
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Effortlessly integrate a powerful, AI-driven chatbot onto your WordPress site with PraisonAI.

== Description ==

PraisonAI provides the simplest way to add an interactive AI chatbot to your website. Powered by OpenAI, this plugin allows you to place a fully functional chat interface on any page or post using a simple shortcode.

Engage your visitors, answer their questions, and provide instant support without any complex setup. All you need is your OpenAI API key to get started.

**Key Features:**

*   **Easy Integration:** Use the `[praisonai_chat]` shortcode to add the chatbot anywhere on your site.
*   **Secure API Key Storage:** Your OpenAI API key is stored securely in your WordPress database and is never exposed to the public.
*   **Simple Settings:** A clean and simple settings page to manage your API key, complete with a show/hide toggle for added security.
*   **Clean & Modern Interface:** A responsive and user-friendly chat interface that fits seamlessly into any WordPress theme.
*   **Lightweight & Optimized:** Scripts and styles are loaded only on pages where the chat shortcode is present, ensuring no unnecessary bloat on your site.

== External Services ==

This plugin connects to the OpenAI API to provide AI-powered chat functionality.

Service Used: OpenAI API
Purpose: The plugin sends user chat messages to OpenAI API to generate intelligent responses.
Data Sent: User chat message text and conversation context when user submits a message.
Privacy Policy: https://openai.com/policies/privacy-policy
Terms of Use: https://openai.com/policies/terms-of-use

== Installation ==

1.  Upload the `praisonai` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2.  Activate the plugin through the 'Plugins' screen in WordPress.
3.  Go to **Settings > PraisonAI** in your admin dashboard.
4.  Enter your OpenAI API key and click **Save Changes**.
5.  Add the `[praisonai_chat]` shortcode to any page or post where you want the chatbox to appear.

== Screenshots ==

1. The PraisonAI chatbot in action on a WordPress page.

== Changelog ==

= 1.0.3 =
* Fixed: Properly enqueue admin JavaScript using wp_enqueue_script instead of inline script tags.
* Added: External Services documentation for OpenAI API usage with privacy policy and terms of use links.

= 1.0.2 =
* Updated Author URI and Donate link to mer.vin for ownership verification.

= 1.0.1 =
* Minor version bump for resubmission.

= 1.0.0 =
*   Initial release.
*   Added AI chat functionality via the `[praisonai_chat]` shortcode.
*   Created a secure settings page for OpenAI API key management.
