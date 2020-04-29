So this has been a long time coming, but here's a new release. Okay it's still early access, I just needed to get something out there for the following reasons:
To show I'm back
To fix some security issues that could affect earlier releases

Now this release addresses a vulnerability in Xtream Codes where a person could restream your streams without a valid user ID, making them invisible. To address this I've enforced some security settings, also implemented a cron that checks for invalid streams and kills them. On top of this I've enforced mag locks and minimum password length of 8 characters for resellers. You CAN change these settings back, but they're forced on every update.

An Xtream UI flaw I've known about for a while is relating to XSS (Cross-Site Scripting), I planned to fix this months ago but never really got around to it, and didn't really anticipate how dangerous this could be so I've made much more of an effort this time around. I now believe this release to be fully patched against any XSS attacks and I've also reinforced any SQL statements to ensure they're correctly escaped to block SQL injection attacks. This is easily the most secure release yet.

I've removed auto-update entirely, however the current version can be checked by going to the Settings page. As well as this, I've also included a GeoLite2 update option. Head to the settings page and if an update is available you can click to install it. My server periodically downloads the GeoLite2 database direct from MaxMind so it's all automated.

On top of the above I've also reintegrated the database editor, however password protected with your MySQL password. To get this MySQL password, run the config.py file in the pytools folder and decrypt your configuration file. Store this somewhere so you can access the database when required.

Tables are updated automatically now so there's no need to click the Update Tables option etc. This will only work if permissions are correct, and Xtream UI will warn you if this isn't the case on the login screen. To fix permissions run the new permissions.sh file in /home/xtreamcodes/iptv_xtream_codes.

This may not seem like the biggest update in the world, but it's a very important one and marks my return to releasing new features. Release schedule will be set in advance, with the plan to be fortnightly. This will happen once 22 becomes official, integrating a few more features and bugfixes before that happens.

The rest of this release consists of various bugfixes, I've read through various posts and integrated what I could.



Next Official Release (22 Official):
I will be implementing further bugfixes along with completing the translation. The current release is about 80% translation mapped, once this is 100% I'll have it translated into various languages for 22 official.



Future Release (23 EA):
VPN Integration! I told you it was coming, and it will be. Okay okay, there was a delay, but still. It's coming.

The plan is to give Xtream UI users the ability to host their own VPN servers, with Xtream UI automatically installing and managing those servers for you. You click Install VPN, give it the IP and root SSH credentials and the installer will do it's thing.

VPN capability can be allocated to packages, with a separate option for max simultaneous connections. The VPN will only be authenticated during the period of the package. When a user is given access to the VPN, they authenticate to the API using their line username and password so they don't need an additional set of credentials, however the actual VPN authentication takes place with a secure certificate generated on the main panel. The VPN servers will have NFS access to the certificate folder to authenticate, and will use an API to communicate back to the main server to show usage statistics, upload, download, current users, CPU usage, memory usage, uptime etc.

VPN servers will be load balanced per country / city, will adhere to max connection per server limits and you'll be able to see throughput on the dashboard to ensure your servers aren't overloaded. Full logging is available in the interface.

As it's OpenVPN based, you can connect via the OpenVPN client for Windows, Android, iOS or many other devices. The users will be able to download their certificates from the panel (if the setting is enabled) or use an URL / QR Code. I've built a very basic Android app that's completely open source and will be provided free of charge, I want those more experienced with Java than I am to make improvements to it and release to the public, and the idea is that whoever wants it can rebrand it and utilise it.

Here's a quick demo of the basic app:
https://streamable.com/a9s51

I'll be providing my own API, but will also ensure Xtream UI is backwards compatible with other VPN API's such as DeployVPN.




Changelog for this Release:
Refined santisation for speed. No longer sanitises MySQL output, only input.
Added STB lock reset to MAG Events for those who have issues with MAG devices.
Added a timeout to mysql queries for those with too many user_activity entries for the page to load.
Removed auto-refresh on user_activity as there are usually too many entries.
Fixed sort functions on User IP's page.
Fixed stream table on created channel page.
Added a sanitisation script to scan the database for unsanitised input and correct it. Only needs to be run once (see below).

To run the sanitisation script, if you believe your server to have been infiltrated in previous releases, run this:
CODE: SELECT ALL

/home/xtreamcodes/iptv_xtream_codes/php/bin/php /home/xtreamcodes/iptv_xtream_codes/adtools/sanitise.php
It'll take a while but it checks the entire database for any malformed or malicious input.



Previously in R22 Early Access (A-D):
Fixed movies not showing in bouquet order.
Forced security upgrades to fix Xtream Codes exploit.
Patched all files against XSS exploits.
Added GeoLite2 updater.
Reintegrated database editor.
Added user-agent to Live Connections page.
Fixed search not being actioned on refresh.
Added stream icons to stream page.
Added EPG status indicator to stream page.
Added settings option to disable auto-refresh by default.
Ensured quotes " don't appear in bouquets in SQL. Can break things otherwise.
Fixed any bouquet issues (I believe).
Added noindex and nofollow to header to deter search engines from indexing.
Updated NGINX to newer, faster version.
Removed reseller API for now, the code may be insecure.
Fixed activity logs page.
Added interactive connection statistics to dashboard plus cron. Enable in Settings.
Added port selection to Install Load Balancer.
Added ability to change port. Edit server, change the ports. Restart server afterwards.
Added ability to reboot server instead of just restart services.
Fixed newline in textareas.
Changed year to appear in brackets instead of after a hyphen.
Added option to extend sidebar in profile.
Fixed various bugs.
70% translation completed... taking it's swweeeett time.
Hidden expired MAG / Enigma passwords in reseller dashboard.
Added current release to Settings page so you can stay up to date.
Added advanced manual channel order.
Added bouquet ordering.
Partial localisation.
Fixed movie and episode adding, MySQL was parsing order as a command rather than column.
Fixed various page bugs due to XSS parsing by implementing HTML Purifier.
Fixed 2020 years not parsing in the python parser.
Fixed EPG URL not parsing correctly due to XSS decode not being available.
Fixed unicode line username and passwords not working.
Fixed never for expiration date (NULL was being parsed as 'NULL').
Fixed Restrictions not showing selected IP's or User-Agents.
New bouquet will be added to end of bouquet list rather than beginning.
Fixed bouquet ordering.
Fixed missing action buttons on Stream page.
Stream icon will show blank if not PNG, this is a limitation of no GD library.
Moved Hash Load Balancers to Settings page under Streaming instead of forced.
Added page to show User IP's per line for the previous Hour, 24 Hours or 7 Days.
Modified directory scanning to work with remote mounts like NextCloud.
Added "strict" to Geo IP options.
Added ISP to Activity Logs. Requires modifications to your main & LB's. Enable in settings.
Various bug fixes.

Yes this includes a rudimentary implementation of ISP's. I'll be adding ISP blocking etc in the next release but for now I've just implemented the API that actually grabs them. It's currently limited to 1,000 requests per day so if you have a lot of connections don't turn it on yet or you'll exhaust your limit immediately. Wait until I implement it in full as I'll have an unlimited supplier then.

To enable this, go to Settings, Streaming and tick Enable ISP's. You will also need to modify your /etc/hosts file to include the following:
CODE: SELECT ALL

127.0.0.1    api.xtream-codes.com
Next up, you need to modify your Nginx config located at /home/xtreamcodes/iptv_xtream_codes/nginx/conf/nginx.conf and add the following below the last server entry, restart services afterwards. This will only work on port 80 currently, so if you have apache2 running you'll have to kill it:
CODE: SELECT ALL

server {
        listen 80;
        root /home/xtreamcodes/iptv_xtream_codes/isp/;
        location / {
            allow 127.0.0.1;
            deny all;
        }
        location ~ \.php$ {
            limit_req zone=one burst=8;
            try_files $uri =404;
            fastcgi_index index.php;
            fastcgi_pass php;
            include fastcgi_params;
            fastcgi_buffering on;
            fastcgi_buffers 96 32k;
            fastcgi_buffer_size 32k;
            fastcgi_max_temp_file_size 0;
            fastcgi_keep_conn on;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        }
    }
ISP's will show up in User Activity then. Let me know how it goes. If you run a large server, please don't enable this yet as you will overload my request limit and it won't work for anyone.



YOUTUBE TUTORIALS - THANKS emre1393:

https://www.youtube.com/playlist?list=P ... k3JH5U2ekn


TROUBLESHOOTING:
You'll notice most issues are down to permissions, you should probably take note.

PROCESS MONITOR - HIGH CPU / MEMORY USAGE
If you're having issues with high cpu or memory usage, you can list the processes that are causing issues using the process monitor function. Go to the dashboard and click the CPU / Memory Usage of an individual server or select Process Monitor from the settings cog dropdown to begin. It can take a few seconds to enumerate processes but will list anything that is being used by the Xtream Codes user. You can then see what individual streams or processes are causing you the biggest issues.

An example that can cause high CPU usage is having movies set up on one server, but the video files themselves are hosted on another server. This will cause XC to download those files using the system_api.php file to the server and attempt to process them upon completion. Doing this with hundreds of movies will cause you big issues. Best practice is to host the movies on the same server as the one encoding / symlinking them. Try to use symlink more often than not as it's the least intensive.

For high memory usage where you can't isolate the issue, try the following:
viewtopic.php?f=13&t=3014&p=14819

Notes from a trusted user who had 100% CPU and 100% Memory, managed to reduce this drastically using process monitor:
Make sure pid_monitor is in crons.
Clean up streams_sys using stream tools.
Restart services.
For Any high percentage vod - make sure its set to same server as the source and symlink is on.
Any live streams that are high percentage that aren't being transcoded for a reason are likely starting and stopping too much: turn them direct or on demand.

BACKUPS
If backups aren't working for you, run the following command:
CODE: SELECT ALL

sudo chown -R xtreamcodes:xtreamcodes /home/xtreamcodes/

TMDb ISN'T WORKING
Your database may not have updated correctly. Ensure the admin folder has the correct permissions by running the below command:
CODE: SELECT ALL

sudo chown -R xtreamcodes:xtreamcodes /home/xtreamcodes/
Now go to Settings -> Database, click Update Tables.

If it still doesn't work, ensure your TMDb API key is correct and active. If it definitely is, then your mysql user for XC probably doesn't have the right permissions to modify tables. Give the user all the available permissions and it try the above again.


WATCH FOLDERS
To set up folder watching, go to the Settings dropdown, Folder Watch and click Settings. You need to set up your Genre matching here. So firstly, click Update from TMDb to get the latest genres. You can attribute a category that you have created to each TMDb Genre. The first genre for each TV Show or Movie will be the one it selects.

The above is optional, this is for more accurate matching, however you can override these settings in the next step.

To set up a folder to be watched, click the + button on the Folder Watch page and fill out the required details. Make sure you select the correct type or you'll have a bunch of incorrectly allocated movies or episodes. The override settings allow you to select a category that the movie / tv show will default to, or a fallback incase it doesn't match the category allocation you may have set up in the first step. It also has various other options for those who want to customise their matches more.

If your scan doesn't seem to be running, check your crontab with the following command:
CODE: SELECT ALL

sudo crontab -e -u xtreamcodes
Look for watch_folders.php. If it isn't there, delete the crontab_refresh file from the tmp folder of xtreamcodes, and restart the service. If it still isn't there, maybe your crontab for xtreamcodes is immutable as it can't be changed. Up to you to figure that one out.



PROCESS MONITORING
So I've made a process killer that checks all PID's in the database against live PID's on the server, killing any it doesn't need. This could potentially help people running into CPU issues, or just help in general as XC isn't the best at killing PID's.
pid_monitor.zip
(957 Bytes) Downloaded 284 times

To install it, download the file from above and extract it here (on each server you want it running on, include LB's):
CODE: SELECT ALL

/home/xtreamcodes/iptv_xtream_codes/crons/


INSTALL

For manual update, download the release from the link below.
http://xtream-ui.com/releases/release_22e.zip



Update Script
CODE: SELECT ALL

apt-get install unzi