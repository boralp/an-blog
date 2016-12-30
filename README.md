# an-blog

PHP static blog engine under 50 lines

  - Pages
  - Posts
  - Full markdown support with http://parsedown.org
  - Single .php file to run.

## Install

### Retrieve
To install an-blog you only need to pull or download the files into your server. No composer or other third party framework to run.

Plug and Play.

Git Pull
```shell
git pull https://github.com/boralp/an-blog/
```

Download
```shell
https://github.com/boralp/an-blog/archive/master.zip
```

### Installation
You should re-set base address to work on your domain other than that there is nothing to configure to work or no other plugin, the repository contain `.htaccess` and `web.config` files for both Linux and Windows servers. The system is PHP 7 compatible.

## Configuration
You should start with configuring your setup from _config.json

### _config.json
 - `base` the full url of your site, e.g., "https://www.arat.net/boralp/".
 - `title` the title of your site, e.g., "AN-Blog".
 - `description` a few sentences description of your site.
 - `index` the openening markdown file in your site.
 - `404` the 404, not found page's markdown file.
 - `temp` the name of your template there are two pre-designed template in the directory, horizontal, and vertical.
 - `social` an array of your social networks, any key-value item will be sufficient.
 - `menu` a two step array, first level is the name of the menu and second level contains the names of markdown files.
 - `footer` the copyright text of your website.

## Blogging
an-blog contains three types of files `system`, `post`, and `page`. They all are markdown and under the folder of items.

### Posts
To add a post and make the order in place, date-title naming used. The first line of the file should be `h1` tag and the name of the page and file name should not contain any spaces the url encoding is not perfect for now.

The difference between post and page is pages are hidden items until you link them to source, posts are always shown on the homepage of the site.

### Example post
Path of the post:
`/items/2016-12-31-New-Year-s-Eve.md`

URL of the post:
`{base}/2016-12-31-New-Year-s-Eve`

Content of the post:
```shell
# Today is new year's eve!
## It is a great day!
```

### Example page
Path of the page:
`/items/about.md`

URL of the page:
`{base}/about`

Content of the page:
```shell
# About me!
## This is my first blog!
```

### 404

For the sake of simplicity 404! Error pages are put as markdown files and their path is under items folder and their name declared in `_configuration.js` and default name is `404.md`.

### index

Index files are markdown as well and after the index file blog posts will be looped, their name can be changed by `_configuration.js` and default name is `home.md` .

