# lleoblog
Full CMS for Diary or Site


INSTALLATION

1. BEFORE START

    Download content in the root of site or folder, move config.sys.tmpl to config.sys and edit. The most important is MySQL setting:

        $msq_host = "localhost";
        $msq_login = "root";
        $msq_pass = "MySIC1234";
        $msq_basa = "blogs";
        $msq_charset = "cp1251";

    If you install engine NOT IN THE ROOT of site (folder blog/ for example):
    -- set $blogdir = "blog/"; in config.sys
    -- if you use apache: set "RewriteBase /dnevnik/" instead "RewriteBase /" in .htaccess

    If you use nginx you have to:
	-- disallow "hidden/" folder
	-- redirect all unknown pages to index.php
	Example of nginx.conf below.

2. STARTING

    Try to open http://yoursite.com/install, reload the page and follow the instructions.

3. AFTER INSTALLATION

    WARNING!!! All visitors has the admin permissions!!!

    You have to set admin:
    -- Set $admin_unics="99999999"; (unknown unic) in config.sys
    -- Reload http://yoursite.com/install, press "U" button or click the right-top icon for open you Personal Card, read your unic in header (number 1 for example)
    -- Set $admin_unics="1"; in config.sys
    -- Reload http://yoursite.com/install The yellow ball in left-top corner means admin. Click one for open admin' menu.










If you use nginx, nginx.conf example below:


upstream home {
  server unix:/var/run/home-fpm.sock;
}

server {
  listen 80 default_server;
  listen [::]:80 default_server ipv6only=on;

  root /var/www/home;
  index index.php index.html index.htm index.shtml;

  server_name lleo.me;

  client_max_body_size 500M;

  location /hidden {
    deny all;
    return 404;
  }

  location / {
    try_files $uri /index.php?$args;

    access_log /var/www/home/hidden/nginx/access.log;
    error_log /var/www/home/hidden/nginx/error.log;

    location ~ \.php$ {
      fastcgi_split_path_info ^(.+\.php)(/.+)$;
      fastcgi_pass unix:/var/run/home-fpm.sock;
      fastcgi_index index.php;
      include fastcgi_params;
      proxy_set_header Host $host;
      proxy_set_header X-Real-IP $remote_addr;
      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
      client_max_body_size       500m;
      client_body_buffer_size    128k;
      proxy_connect_timeout      90;
      proxy_send_timeout         90;
      proxy_read_timeout         90;
      proxy_buffer_size          4k;
      proxy_buffers              4 32k;
      #proxy_buffers           32 4k;
      proxy_busy_buffers_size    64k;
      proxy_temp_file_write_size 64k;
    }
  }
}