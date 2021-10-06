# Docker stuff

In part, this project is an opportunity for me to learn docker, so these are my
notes.  Let me repeat that, **these are my notes**, not comprehensive
documentation!  I just need to keep track of what I did, so this message is
really here for your benefit if you happen to stumble across this project.  At
some point, I may write up some good documentation.

I develop on Ubuntu 18.04, and typically deploy to a Red Hat based system.

## Pre-Installation and Requirements

Before installing Laravel, I had to do all this.

I installed `docker` and `docker-engine` following the
[official install guide](https://docs.docker.com/engine/install/ubuntu/), which worked
perfectly.  I'm pretty sure I installed _using the repository_ method.

I also installed `docker-compose`. First, find out what the latest release is from the official
[github repo](https://github.com/docker/compose/releases), then substitute the appropriate
version in the following:
```
sudo curl -L "https://github.com/docker/compose/releases/download/1.28.5/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# verify it's installed
docker-compose --version
```

For Laravel, I also needed be able to _Manage docker as a non-root user_ from the
[post-installation](https://docs.docker.com/engine/install/linux-postinstall/) instructions.

As per the instructions, finally run: (do I need to run this after every reboot?
```
docker context use rootless
```

## Installing Laravel

Copy `.env.example` to `.env` and change the DB parameters (DB_USERNAME to something NOT root).

Once you have cloned this project, and have docker installed, you can "setup" the app by running:
```
docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```
NOTE!!! The [official doc](https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects)
also has includes the line `-u "$(id -u):$(id -g)" \` in the previous command. But for me, that caused permission issues
inside the container.

### Create a new Larvel app
Just for reference, to create a new Laravel app using docker, follow the official installation instructions using
[docker/sail](https://laravel.com/docs/8.x/installation#getting-started-on-linux). For now (and for the forseeable
future) I only need postgres, so I used:
```
curl -s "https://laravel.build/trackaler?with=pgsql" | bash
```


## Helpful Links

I struggled to wrap my mind around how docker works and how to use it for development. Here are some
links that were initially very helpful.

* https://tech.osteel.me/posts/docker-for-local-web-development-introduction-why-should-you-care
* https://phoenixnap.com/kb/how-to-ssh-into-docker-container
* https://phoenixnap.com/kb/how-to-commit-changes-to-docker-image
* https://blog.container-solutions.com/understanding-volumes-docker

* https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose
* https://rootdaemon.com/2021/01/10/you-dont-need-laravel-sail/

## Docker cheat sheet

This list undoubtedly evolve as my understanding evolves. For now, it's a
hodgepodge of `docker`, `docker-compose` and `sail` commands.

Most of the `docker-compose` commands can simply be substituted with `sail`,
and vice versa, since for the most part sail is just a proxy for `docker-compose`.

Start the dev env (start and run all containers in the background)
```
sail up -d
```

Stop and destroy all containers (I think this is typically what you want to
do).  This will preserve any persisted database changes.
```
sail down
```

Stop and destroy all containers and their volumnes. Note, by destroying the
volumes, you wipe out the db.
```
sail down -v
```

Delete everything, containers, volumes, images, and orphaned containers
```
docker-compose down -v --rmi all --remove-orphans
```

Show what is running
```
# shows running services
sail ps
docker-compose ps

# shows running containers
docker ps
```

Restart a process with a running container. I think...  I'm still a little
unclear on this one.  I think it's for, if you want `httpd` to restart because
you've modified it's config, but the container is still running.
```
docker-compose restart
```

Connect to a running container (use `exit` to quit). There are a variety of
ways to do this. Note the different uses of _container_ vs _service_.  Services
are defined in the `docker-compose.yml` file, and listed using `docker-compose
ps` or `sail ps`. Containers can be listed using `docker ps`.
```
# will only connect to the laravel service
sail shell

# connect to any service using exec
sail exec pgsql bash

# conect to a container
docker exec -it <container-name-or-id> bash

# for example:
docker exec -it tracal_httpd_1 bash
```

View container logs
```
# tail and follow all container logs
docker-compose logs -f

# tail a single service's logs
docker-compose logs <service>

# for example
docker-compose logs httpd
```

Run a single command and then trash the containner
```
docker run --rm <image-name> <command> > my-httpd.conf

# for example:
docker run --rm httpd:2.4 cat /etc/apache2/apache2.conf > my-httpd.conf
```


## Database backup and restore

To backup the db in a running container
```
# sail calls docker-compose, which you pass a 'service'
sail exec pgsql pg_dump -U $dbuser tracal > tracal.db.sql

# to use docker directly, pass a container name or id
docker exec tracal_pgsql_1 pg_dump -U $dbuser tracal > tracal.db.sql
```

To restore to a db in a running container
```
# sail calls docker-compose, which you pass a 'service'
# also note the -T which allows it to read from stdin
# sail exec -T pgsql psql -U $dbuser $dbname < tracal.db.sql
sail exec -T pgsql psql -U tracalweb tracal < tracal.db.sql

# to use docker directly, pass a container name or id
docker exec -i tracal_pgsql_1 psql -U $dbuser tracal < tracal.db.sql
```

Note, in my local dev env, the above is sufficient. However, you may need to
add additional parameters for other configs. For example;
```
echo tracal.db.sql | sail exec -T pgsql exec bash -c "export PGPASSWORD=$dbpass && psql -h $dbhost -U $dbuser tracal"
```


## Managing Laravel

To install new packages
```
sail composer require laravel/sanctum
```

To upgrade a package, edit composer.json, then
```
sail composer install
```

## Docker and IPv6

On Ubuntu 18.04, an update to docker 20.10.6 broke networking (docker will not
start) if ipv6 is disabled (in /etc/default/grub).

A solution that worked for me was a [suggestion by jflambert (comment 6)](https://forums.docker.com/t/ipv6-disabled-on-my-computer-but-docker-network-seems-looking-for-it/107299/9).
Add the localhost to the port. My docker-compose.yml contains lines like
`${APP_PORT:-80}:80` for `laravel.test: ports:` and
`${FORWARD_DB_PORT:-3306}:3306` for `mysql: ports:`. So in my .env, I modified to add the
localhost ipv4 ip address like this:
```
#APP_PORT=8080
APP_PORT=127.0.0.1:8080
#FORWARD_DB_PORT=33060
FORWARD_DB_PORT=127.0.0.1:33060
```

One alternative is to keep ipv6 disabled and rollback to docker 20.10.5 like this:
```
apt install docker-ce=5:20.10.5~3-0~ubuntu-bionic
```

You might also want to “hold” the package for now
```
apt-mark hold docker-ce
```

you can later unhold the package using
```
apt-mark unhold docker-ce
```

