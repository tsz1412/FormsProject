# Instructions
## Prerequesties
1. Insure installation of Docker Program on pc/mac
2. Turn off all NGINX/APACHE/MYSQL/PHP Proccess running on the local machine
3. make sure all Dockers are off by running `docker ps` from shell
4. Install PHP composer globally to be able edit PHP dependencies
5. Install latest stable version of Node to be able recompile JS files
## Instructions
1. Place SSL keys provided in the email inside an SSL folder in the root folder of the project.
2. Run `docker-compose up -d` from the root folder of the project
3. Inside the local hosts file in your machine add the following record at the bottom of the file:
   `formproj-dev.tszsol.com 127.0.0.1`
    * File locations:
      * Windows: `c:\Windows\System32\Drivers\etc\hosts`. Use notepad to edit the file and save.
      * Mac/Linux: Run `sudo [nano/vi/vim] /etc/hosts`. Replace [nano/vi/vim] with your favorite cli editor
    * This must be done from your local hosts file. accessing the file from Ubuntu CLI installed on Windows machine <b> Won't work </b>
4. Enjoy
5. Upon finishing reviewing the project, run `docker-compose down` from the root folder of the project to stop all Docker containers
## Wordpress Credentials
Username: `admin`

Password: `123456`
## Docker Managment
### Take DB Backup
docker exec site_mysql /usr/bin/mysqldump -u root --password=rootpass wp_mfa3u > backup.sql
