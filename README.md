#Setup dev environment
Download PrestaShop and choose version to work on
```
git clone git@github.com:PrestaShop/PrestaShop.git
cd PrestaShop
git checkout 1.7.7.5
```
For PrestaShop 1.7.7.5 change php version in .docker/DockerFile to 7.3: `FROM prestashop/prestashop-git:7.3`
Clean older builds
```
docker container prune
docker volume prune
docker image prune -a
git clean -xdf
```
Run docker-compose 
`docker-compose up`

#Install the module
Add Bob the module
```
cd modules
git clone git@github.com:kantum/bobthemodule.git
cd ..
```

Connect to admin section: http://localhost:8001/admin-dev
user: `demo@prestashop.com`
pass: `prestashop_demo`
