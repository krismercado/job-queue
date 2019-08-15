# Laravel Job Queue

In your local kindly cd through the job-queue folder and run the ff.:

### install library dependencies
composer install

### this will initiate the docker instances
docker-compose up -d

### migrate queue table
docker exec queue php artisan migrate:fresh 

### manual commands - no need to execute since the queue executes to check pending jobs every minute
docker exec queue php artisan start:queue normal

URL: http://www.127.0.0.1.nip.io/
