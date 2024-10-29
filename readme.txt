=== AJAX Referer Fix ===
Contributors: basvd
Tags: permission, problem, fix, bug, workaround, error
Requires at least: 2.0.3
Tested up to: 2.3.3
Stable tag: 0.1

Fixes a problem that causes "You don't have permission to do that" errors. It replaces the pluggable check_ajax_referer() with a safe alternative.

== Description ==

**Note:** This plugin does not work in WP 2.5. The AJAX referer check in WP 2.5 does not conflict with a hardened version of PHP, so this plugin is no longer adequate.
If you still experience the permission problem it is likely your browser or a plugin.

This plugin fixes an issue that can cause several problems in the Administration Panel, including the following:

1. The "You don't have permission to do that" error when performing certain actions, even though you are in fact logged in
2. The "Are you sure you want to edit this page: ""?" confirmation when trying to save a post or page
3. Inability to remove pages or posts using the Management panels
4. And possibly other problems that have similar symptoms

Most people who get these problems seem to be on a server that uses a hardened version of PHP. This version adds several security measures to PHP, including transparent cookie encryption. The WordPress function that checks whether you can perform certain actions in the Administration Panel (`check_ajax_referer()`) does not function properly because of this. This plugin replaces that function with a something that does take the cookie encryption into account.

== Installation ==

After you've downloaded and extracted the files:

1. Upload the complete `ajax-referer-fix` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Verify whether the fix solves your problem


== Frequently Asked Questions ==

= Why do I need this plugin? =

You only need this plugin if you are experiencing any of the perviously mentioned problems. If WordPress is working fine without it, then don't waste your time on this.

**Note:** WP 2.5 users do not need this plugin. It will not work.

= Is this fix secure? =

*Short answer:* Yes. *Longer answer:* The replacement function provided by this plugin uses the same validation method as the original function. There is one difference and it has to do with encrypted cookie data. I suggest you have a look at the source code (it's commented) if you want to find out how it works exactly. The replacement function is no less secure than the original.

= It does not solve my problem =

You may be experiencing one or more of the previously mentioned problems for a reason unrelated to AJAX or encrypted cookies. In that case, this plugin is unlikely to solve it. However, it could also be possible that the plugin just isn't perfect. In any case, it would be really helpful if you contacted me about your problem and providing the following information:

1. Your PHP version (as displayed by the output of `phpinfo()`)
2. Hardened PHP Patch version (if any, try searching for 'Hardened', 'Suhosin' or 'Patch' in the output of `phpinfo()`)
3. The value of `suhosin.cookie.encrypt` (as displayed by the output of `phpinfo()`)
