# piscreen
**Displaying a webpage on a screen by a Raspberry Pi**

# bulletin
**Running a Google slide show with a top info bar on a screen attached to a Raspberry Pi**

* Required: sudo apt-get grep sed cron libraspberrypi-bin(vcgencmd)[displ]
  git surf unclutter xdotool lxsession php-cli
  coreutils(cd mkdir mv cp chmod head ln)
* Repo: https://gitlab.com/pepa65/bulletin
* If the display needs to be refreshed after a slides change or for some other
  reason, go to: `http://SITE/refresh.php` (SITE is IP:PORT).
* The script `refr` can be run to refresh the browser.
* The script `displ` can be run to turn the display on or off.
* The script `show` controls the start & stop of the browser and web server.
  (See `show --help` for all options.)

## Function
* For **piscreen** a specified URL is displayed in the browser on startup.
* For **bulletin** a Google Slides presentation is running in the browser
  in an iframe with a bar on top with logo, title, time and AQI.
  This is served by a webserver from `web/index.html`.
* In both cases, the browser is started through the LXDE lxsession `autostart`
  file, which calls `show` (also starting a web server to serve **bulletin**
  and refresh.php).

## Install
### Raspberry OS
Install Raspberry OS. Use `raspi-config` to configure the wireless connection.
Enabling an ssh server is recommended for remote access.

### Screen
For the **bulletin** the `web/index.html` file assumes a certain screen size. 
Configure the screen resolution with `raspi-config` (Advanced, Resolution).
If the display needs to be rotated, add a line like this to `/boot/config.txt`:

`display_hdmi_rotate 3`

(Using `3` rotates the display 90 degrees counter-clockwise and `1` clockwise).

If there is overscan (content not aligning well with screen edges), the
`setoverscan` tool can be used from https://github.com/pepa65/setoverscan

### Automated Install
* Download the file `https://gitlab.com/pepa65/bulletin/raw/master/INSTALL`
with wget: `wget -qO INSTALL 4e4.win/piscreen`
* Edit the top of `INSTALL` to have either URL or GSURL defined.
* Then the whole manual install can be skipped by doing: `bash INSTALL`

### Manual Install
Studying what happens in INSTALL will give more clues as to what is needed..!

#### Home directory
The assumption is that the user is `pi` with home directory `/home/pi`.
The file `autostart` and `displ` need to be changed if not!

#### Packages
Install all the required packages:

`apt install git surf unclutter xdotool lxsession php-cli libraspberrypi-bin`

#### Download
Clone the git repo:

`mkdir -p ~/git; cd ~/git; git clone https://gitlab.com/pepa65/bulletin; cd bulletin`

#### Autostart
The file `autostart` for the lxsession autostart file needs to be linked in:

__Watch out for a different directory under lxsession!__

`lxconfdir=~/.config/lxsession/LXDE; mkdir -p "$lxconfdir"`

`ln -sf "$PWD/autostart" "$lxconfdir"`

#### Set URL
`cp _show show`

At the top of `show` set SITE (IP:PORT with IP of the Pi and desired PORT).
(Suitable IP addresses can be gleaned by: `ip a |grep -o 'inet[^ ]* [^/]*'`.)

* For **bulletin** replace `GSURL` with the base URL of the Google Slides in
  file `web/index.html` (after `cp web/_index.html web/index.html`).
* For **piscreen** set the URL in `show`!**

#### Set screentimes
Add crontab lines to turn the screen on & off at certain times:
`crontab -l |grep -q bulletin/displ && {	crontab -l; echo -e "\n# Display On at 7:00 Mo-Fr on a schoolday\n0 7 * * 1-5 $repo/displ"; echo -e "\n# Display Off at 17:00 Mo-Fr\n0 17 * * 1-5 $repo/displ off\n";} |crontab -`
