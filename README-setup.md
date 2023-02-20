# Intial Setup

* See previous warnings about the quality of this documentation...
* See [README-docker.md](README-docker.md) for additional docker stuff

**My Dev ENV is currently broken due to permission issues in the container**.
See Permission Issues section below.

## Requirements

**NOTE**: I'm doing  all development in docker. Thus, I do not have php,
apache, compser, etc installed on my local machine.

Install `docker` and either `docker desktop` or `docker-engine`. See `README-docker.md`.

## Permission Issues

Starting on Ubuntu 22.04, I only installed docker desktop. It seems there are
permission issues in the containers which I have not been able to resolve. This
issue may have something to do with it: https://github.com/laravel/sail/issues/548

Switch the context to use `docker engine` running the following command: `docker context use default`

Switch the context in order to use `docker-desktop` with: `docker context use desktop-linux`


## Installing Laravel App

This section is incomplete... I need to fix the permission issues.

1) Clone this repo
```
git clone git@github.com:mjeffe/trackaler.git
```

2) Do the annoying Laravel directory permission fix (not, I just make them world
writeable since I don't have apache installed)
```
sudo chmod -R ugo+rwx storage
sudo chmod -R ugo+rwx bootstrap/cache
```

3) Copy `.env.example` to `.env` and change the DB parameters (DB_USERNAME to something NOT root).

4) Once you have cloned this project, and have docker installed, you can "setup" the app by running:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

5) Build containers and bring up the app
```
sail up -d
```

6) Install npm stuff
```
sail npm install
```

