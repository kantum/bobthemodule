# Setup dev environment
Download PrestaShop and choose version to work on
```
git clone git@github.com:PrestaShop/PrestaShop.git
cd PrestaShop
git checkout 1.7.7.5
```
For PrestaShop 1.7.7.5 change php version in .docker/DockerFile to 7.3:
```
FROM prestashop/prestashop-git:7.3
```
Clean older builds if needed
```
docker container prune
docker volume prune
docker image prune -a
git clean -xdf
```
Run docker-compose 
```
docker-compose up
```
# Install the module
## For development
Add Bob the module
```
cd modules
git clone git@github.com:kantum/bobthemodule.git
```
Connect to admin section: http://localhost:8001/admin-dev

user: `demo@prestashop.com`

pass: `prestashop_demo`

## For production

Download the zip file `bobthemodule.zip` on github release page

Go to your backend and clic `upload a module`

Find the bobthemodule.zip file

You will be able to place bob on the left column under the Design/Position tab
