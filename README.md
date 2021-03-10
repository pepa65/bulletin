# piscreen
**Displaying a webpage on a screen by a Raspberry Pi**

# bulletin
**Running a Google slide show with a top info bar on a screen attached to a Raspberry Pi**

* Required: sudo apt-get grep sed cron libraspberrypi-bin(vcgencmd)[displ]
  git surf unclutter xdotool lxsession php-fpm[bulletin]
  coreutils(cd mkdir mv cp chmod head ln)
* Repo: https://gitlab.com/pepa65/bulletin
* If the **bulletin** needs to be refreshed after a slides change, go to:
  `http://SITE/refresh.php`
* The script `f5` can be run to refresh the browser
* The script `displ` can be run to turn the display on or off
+ The script `show` controls the start & stop of the browser (and web server)

## Function
* For **piscreen** a specified URL is displayed in the browser on startup.
* For **bulletin** a Google Slides presentation is running in the browser
  in an iframe with a bar on top with logo, title, time and AQI.
  This is served by a webserver from `web/index.html`.
* In both cases, the browser is through the LXDE lxsession `autostart` file,
  which calls `show` (which also starts the web server for **bulletin**).
  Calling `show stop` stops the browser (and web server), while `show start`
  restarts (and `show log` starts and logs).

## Install
### Raspberry OS
Install Raspberry OS. Use `raspi-config` to configure the wireless connection.
Enabling an ssh server is recommended for remote access.

### Screen
For the **bulletin** the `web/index.html` file assumes a screen size of 
Configure the screen resolution with `raspi-config` (Advanced, Resolution).
If the display needs to be rotated, add a line like this to `/boot/config.txt`:

`display_hdmi_rotate 3`

(Using `3` rotates the display 90 degrees counter-clockwise and `1` clockwise).

If there is overscan (content not aligning well with screen edges), the
`setoverscan` tool can be used from https://github.com/pepa65/setoverscan

### Automated Install
Download the file `https://gitlab.com/pepa65/bulletin/raw/master/INSTALL`
with wget:

`wget 4e4.win/piscreen`

Edit the top of the `piscreen` script to have either URL or GSURL defined.

Then the whole manual install can be skipped by doing: `bash INSTALL`

### Manual Install
Studying what happens in INSTALL will give more clues as to what is needed.

#### Home directory
The assumption is that the user is `pi` with home directory `/home/pi`.
The file `autostart` and `displ` need to be changed if not!

#### Packages
Install all the required packages:

`apt install git surf unclutter xdotool lxsession php-fpm libraspberrypi-bin`

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

* For **bulletin** replace `GSURL` with the base URL of the Google Slides in file `web/index.html`.
* For **piscreen** set the URL in `show`!**

#### Set screentimes
Add crontab lines to turn the screen on & off at certain times:
`crontab - < <(crontab -l 2>/dev/null; echo -e "\n# Display On at 7:00 Mo-Fr on a schoolday\n"'0 7 * * 1-5' "$HOME/git/bulletin/displ\n\n# Display Off at 17:00 Mo-Fr\n"'0 17 * * 1-5' "$HOME/git/bulletin/displ off\n")`
