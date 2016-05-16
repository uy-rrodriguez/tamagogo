# N from meaN
echo N from meaN. Installing NodeJS.
curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash -
sudo apt-get install -y nodejs

# M from Mean
echo M from Mean. Installing MongoDB, a NoSQL DBMS.
sudo npm install -g mongodb

echo Installing the MEAN.io dependencies.
# Build tool used by mean.io
sudo npm install -g gulp

# Front end packages manager, used by mean.io
sudo npm install -g bower

# Mean.io
sudo npm install -g mean-cli


echo Done!

