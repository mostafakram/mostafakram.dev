---
extends: _layouts.post
section: content
title: Deploy NuxtJS with Laravel Backend on Forge
date: 2021-08-01
featured: true
description: Deploying server side NuxtJS web app powered by Laravel apis backend on Laravel Forge.
cover_image: /assets/img/muhannad-ajjan-sL2BRR1cuvM-unsplash.jpg
credits: Photo by <a href="https://isword.me">Muhannad Ajjan</a> on <a href="https://unsplash.com/@isword?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
categories: [devops, laravel]
---

Deploying a server side rendering [Nuxt.js](https://nuxtjs.org) app with a Laravel api backend on Laravel [Forge](https://forge.laravel.com) was not a straight forward process. So here is what my collegues and I have done.

## The App

We have a Laravel backend app that has explored its apis under `/api/*`. We have Laravel Nova installed for admin panel. And of course a Nuxt.js frontend app.

This article shows deploying Nuxt.js for server side rendering not static generated. Which means that Node.js server is required. From the [docs](https://nuxtjs.org/docs/2.x/concepts/server-side-rendering):

> Server-side rendering (SSR), is the ability of an application to contribute by displaying the web-page on the server instead of rendering it in the browser. Server-side sends a fully rendered page to the client; the client's JavaScript bundle takes over which then allows the Vue.js app to hydrate.


If you want to deploy a static generated Nuxt.js app where node is not required check out [Deploying Your Nuxt.js Site To Laravel Forge](https://blog.laravel.com/deploying-your-nuxtjs-site-to-laravel-forge) by James Brooks

# The Project

## The Structure

Your Laravel project folder structure will look something like this

```
-- Your Project
    -- app 
    -- client
    -- // other laravel directories 
    -- package.json
    -- tailwind.config.js
    -- nuxt.config.js
    -- ecosystem.config.js
    -- // other files 
```

- The `client` directory is where your Vue.js files
- `nuxt.config.js` is the configuration file for Nuxt.js
- `ecosystem.config.js` is your pm2 configuration file (will get back to this again)

## Configure Nuxt.js

Set the source directory in `nuxt.config.js` to the path of the `client` directory

```javascript

export default {
    srcDir: "client/"
}
```
Set your build directory to be inside `client` directory

```javascript
export default {
    buildDir: "client/.nuxt"
}
```
By default, the Nuxt.js development server port is 3000. You can also change the port number from the default port if needed.


```javascript
export default {
    server: {
        port: 3000
    }
}
```

Check out the [docs](https://nuxtjs.org/docs/2.x/features/configuration) for more configurations available for you.

## Scripts

From the [docs](https://nuxtjs.org/docs/2.x/get-started/commands#using-in-packagejson):

> You should have these commands in your package.json:

```json
{
  "scripts": {
    "dev": "nuxt",
    "build": "nuxt build",
    "start": "nuxt start",
    "generate": "nuxt generate"
  }
}
```

Lets remove generate as we are not going to use it and one more for production deployment so that `package.json` scripts will be

```json
{
  "scripts": {
    "dev": "nuxt",
    "build": "nuxt build",
    "start": "nuxt start",
    "prod": "nuxt build && pm2 restart ./ecosystem.config.js"
  }
}
```

# The Server

## PM2 

PM2 is a process management to manage node.js on the server. 

>Deploying using PM2 (Process Manager 2) is a fast and easy solution for hosting your universal Nuxt application on your server

So make sure you have [installed](https://nuxtjs.org/docs/2.x/deployment/deployment-pm2#getting-started) it on the server 

Pm2 is configured using `ecosystem.config.js` 
```javascript
module.exports = {
    apps: [
        {
            name: 'your-app-name',
            script: './node_modules/nuxt/bin/nuxt.js',
            args: 'start',
            port: 3000, // yoru app port 
            instances: 'max',
            exec_mode: 'cluster',
            cwd: './client'
        }
    ]
};
```
This will handle running node on the server and execute the start command. 

- The `name` is the name of your app that will appear for the process. if you have multiple apps on the same server by thus you can distinguish between them
- The `script` is telling pm2 which script file we need to run, in this case its `nuxt.js` script
- The `args` tells pm2 what arguments to pass to the defined script, we need it to pass `start` as an argument, so the result would be `./node_modules/nuxt/bin/nuxt.js start`

Learn more about configuration file [from here](https://pm2.keymetrics.io/docs/usage/application-declaration/)

## Configure Nginx on the Server

Update your nginx configuration on Forge as mentioned in the [docs here](https://nuxtjs.org/docs/2.x/deployment/nginx-proxy#nginx-configuration-for-laravel-forge)

The issue is if you have done only these, all of your requests to the server will be proxied to `http://127.0.0.1:3000` to the node.js server even your apis and nova routes. But we need to only proxy the frontend routes to `http://127.0.0.1:3000` and keeep others as they are. So lets update our configurations under `Location / { ... }` add

```bash
location ~ ^/(api|nova|nova-vendor|nova-api|vendor) {
        try_files $uri/ /index.php?$query_string;
        location ~* \.(jpg|jpeg|gif|css|png|js|ico|html|svg)$ {
        }
}
```
This will tel nginx that any route that include api, nova, nova-vendor, nova-api or vendor dont proxy it to `http://127.0.0.1:3000` but send it to `index.php` and let Laravel handle it 

This line `location ~* \.(jpg|jpeg|gif|css|png|js|ico|html|svg)$` assure that all of your assets inclduding nova's that are not frontend related accessed correctly.

## Deployment script 

Add to your deployment script on Forge

```
npm install && npm run prod
```

Remember `npm run prod` from `package.json` will execute 
```
nuxt build && pm2 restart ./ecosystem.config.js
```
It will build your app by running`nuxt build` and then restart pm2 by running `pm2 restart ./ecosystem.config.js`

## Deploy 

Deploy your app and that's it, now you have Nuxt.js app with Laravel backend deployed on Laravel Forge. 
