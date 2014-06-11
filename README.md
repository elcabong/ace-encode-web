ace-encode-web
==============

web control for ace-encode

  
full install instructions:

pre reqs  
sudo apt-get install git-core git  
sudo apt-get install abcde cd-discid lame cdparanoia id3 id3v2  
sudo apt-get install eyed3 python3 python3-eyed3  

sudo add-apt-repository ppa:stebbins/handbrake-snapshots  
sudo apt-get update  
sudo apt-get install handbrake-cli handbrake-gtk 

sudo apt-get install build-essential libc6-dev libssl-dev libexpat1-dev libavcodec-dev libgl1-mesa-dev libqt4-dev 

// replace 1.8.6 below with newest version  
wget http://www.makemkv.com/download/makemkv-bin-1.8.6.tar.gz  
wget http://www.makemkv.com/download/makemkv-oss-1.8.6.tar.gz  

tar xvzf makemkv-oss-1.8.6.tar.gz  
tar xvzf makemkv-bin-1.8.6.tar.gz  

cd makemkv-oss-1.8.6  
make -f makefile.linux  
sudo make -f makefile.linux install  

cd makemkv-bin-1.8.6  
make -f makefile.linux  
sudo make -f makefile.linux install  




get ace-encode-web  

sudo apt-get install apache2  
sudo apt-get install php5 libapache2-mod-php5 php5-curl  
sudo service apache2 restart  


git clone git://github.com/elcabong/ace-encode-web.git /var/www/DiskRipper

for ubuntu 14+ you will need to change the default000.conf virtual host to point to this directory, or make a new specific virtual host.  this is because ther eare hard coded paths in the /ace-encode/ files

cd /var/www/DiskRipper/ace-encode  

sudo chmod +x ./*  


set permissions for Ripping folder (2 users need permissions, the user ripping disks and www-data):  
option 1 (permissions for all):
sudo chmod -R 0777 /var/www/DiskRipper 
  
option 2 (specific permissions):  
sudo chmod -R 0775 /var/www/DiskRipper  
sudo chown -R www-data:www-data /var/www/DiskRipper 
sudo usermod -a -G www-data {USERNAME} 



sudo cp ./autorun/.abcde.conf ~  
sudo cp ./autorun/ripcd.desktop /usr/share/applications/  
sudo cp ./autorun/ripdvd.desktop /usr/share/applications/  
sudo cp ./autorun/ripbluray.desktop /usr/share/applications/  
sudo chmod +x ~/.abcde.conf  
sudo chmod +x /usr/share/applications/ripcd.desktop  
sudo chmod +x /usr/share/applications/ripdvd.desktop  
sudo chmod +x /usr/share/applications/ripbluray.desktop  


configre ace-encode  

sudo nano ./settings.conf  

sudo nano ~/.local/share/applications/mimeapps.list  
And add the following at the bottom of the file:  

**************** BEGIN CODE: ****************  
[Default Applications]  
x-content/audio-cdda=ripcd.desktop;  
x-content/video-dvd=ripdvd.desktop;  
x-content/video-bluray=ripbluray.desktop  
[Added Associations]  
x-content/audio-cdda=ripcd.desktop;  
x-content/video-dvd=ripdvd.desktop;  
x-content/video-bluray=ripbluray.desktop;  
***************** END CODE: *****************  

Save the file and then in Ubuntu go to System Settings > Details > Removable Media and then do the following:  

    For CD - Click on the Audio CD drop down, you�ll notice our Rip CD program is listed. Choose this as your default.  
    For DVD - Click on the DVD Video Disc drop down, you�ll notice our Rip DVD program is listed. Choose this as your default.  
    For BluRay - Click on the Additional Settings button and find the option for Bluray Video Disc, you�ll notice our Rip BluRay program is listed. Choose this as your default.  

If all your programs have been installed and set up correctly, you should now be able to insert a disc of your choosing and it will automatically rip the music or movie to your computer.

























////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
old ..  disregard
web control for ace-encode

creating ripping directory structure:  
sudo mkdir /data/Ripping/Blackhole/Movies  
sudo mkdir /data/Ripping/Blackhole/Music  
sudo mkdir /data/Ripping/Blackhole/TV  
sudo mkdir /data/Ripping/BR  
sudo mkdir /data/Ripping/DVD  
sudo mkdir /data/Ripping/logs/BR  
sudo mkdir /data/Ripping/logs/DVD  
sudo mkdir /data/Ripping/Music  


set permissions for Ripping folder (2 users need permissions, the user ripping disks and www-data):  
option 1 (permissions for all):
sudo chmod -R 0777 /data/Ripping  
  
option 2 (specific permissions):  
sudo chmod -R 0775 /data/Ripping  
sudo chown -R www-data:www-data /data/Ripping
sudo usermod -a -G www-data {USERNAME} 

  
full install instructions:

pre reqs  
sudo apt-get install git-core git  
sudo apt-get install abcde cd-discid lame cdparanoia id3 id3v2  
sudo apt-get install eyed3 python3 python3-eyed3  

sudo add-apt-repository ppa:stebbins/handbrake-snapshots  
sudo apt-get update  
sudo apt-get install handbrake-cli handbrake-gtk 

sudo apt-get install build-essential libc6-dev libssl-dev libexpat1-dev libavcodec-dev libgl1-mesa-dev libqt4-dev 

// replace 1.8.6 below with newest version  
wget http://www.makemkv.com/download/makemkv-bin-1.8.6.tar.gz  
wget http://www.makemkv.com/download/makemkv-oss-1.8.6.tar.gz  

tar xvzf makemkv-oss-1.8.6.tar.gz  
tar xvzf makemkv-bin-1.8.6.tar.gz  

cd makemkv-oss-1.8.6  
make -f makefile.linux  
sudo make -f makefile.linux install  

cd makemkv-bin-1.8.6  
make -f makefile.linux  
sudo make -f makefile.linux install  




get ace-encode-web  

sudo apt-get install apache2  
sudo apt-get install php5 libapache2-mod-php5 php5-curl  
sudo service apache2 restart  

ubuntu 14+
git clone git://github.com/elcabong/ace-encode-web.git /var/www/html/  
  
ubuntu 13 and prior
git clone git://github.com/elcabong/ace-encode-web.git /var/www/  



get ace-encode  
sudo git clone git://github.com/joelbassett/ACE-Encode.git /usr/bin/ace-encode  

cd /usr/bin/ace-encode  

sudo chmod +x ./*  
sudo chown {USERNAME}:{USERNAME} ./*  

cd /usr/bin/ace-encode  
sudo cp ./autorun/.abcde.conf ~  
sudo cp ./autorun/ripcd.desktop /usr/share/applications/  
sudo cp ./autorun/ripdvd.desktop /usr/share/applications/  
sudo cp ./autorun/ripbluray.desktop /usr/share/applications/  
sudo chmod +x ~/.abcde.conf  
sudo chmod +x /usr/share/applications/ripcd.desktop  
sudo chmod +x /usr/share/applications/ripdvd.desktop  
sudo chmod +x /usr/share/applications/ripbluray.desktop  


configre ace-encode  

sudo nano ./settings.conf  

sudo nano ~/.local/share/applications/mimeapps.list  
And add the following at the bottom of the file:  

**************** BEGIN CODE: ****************  
[Default Applications]  
x-content/audio-cdda=ripcd.desktop;  
x-content/video-dvd=ripdvd.desktop;  
x-content/video-bluray=ripbluray.desktop  
[Added Associations]  
x-content/audio-cdda=ripcd.desktop;  
x-content/video-dvd=ripdvd.desktop;  
x-content/video-bluray=ripbluray.desktop;  
***************** END CODE: *****************  

Save the file and then in Ubuntu go to System Settings > Details > Removable Media and then do the following:  

    For CD - Click on the Audio CD drop down, you�ll notice our Rip CD program is listed. Choose this as your default.  
    For DVD - Click on the DVD Video Disc drop down, you�ll notice our Rip DVD program is listed. Choose this as your default.  
    For BluRay - Click on the Additional Settings button and find the option for Bluray Video Disc, you�ll notice our Rip BluRay program is listed. Choose this as your default.  

If all your programs have been installed and set up correctly, you should now be able to insert a disc of your choosing and it will automatically rip the music or movie to your computer.
