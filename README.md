# piscreen
**Displaying a webpage on a screen by a Raspberry Pi**

# bulletin
**Running a Google slide show with a top info bar on a screen attached to a Raspberry Pi**

* Required: surf unclutter xdotool lxsession(Raspbian)
* Repo: https://gitlab.com/pepa65/bulletin
* In case the browser needs to be refreshed after a slides change, go to:
  `http://SITE/refresh.php`
* The script `f5` can be run to refresh the browser
* The script `displ` can be run to turn the display on or off

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
Download this file with wget:

`wget -O https://github.com/pepa65/bulletin/raw/master/INSTALL`

All the following can be done with 1 command, installing either **bulletin**
or **piscreen**:
1. `bash INSTALL <BASEURL> <IP:PORT>`  # Installing **bulletin** to display the
   topbar and the BASEURL that are served on the Pi's IP address on PORT.
2. `bash INSTALL <URL>`  # Installing **piscreen** for URL

### Manual Install
The assumption is that the user is `pi` with home directory `/home/pi`.
The file `_autostart` and `displ` need to be changed if not!

#### Packages
Install all the required packages:

`apt install git surf unclutter xdotool lxsession php-fpm`

#### Download
Clone the git repo:

`mkdir ~/git; cd ~/git; git clone https://gitlab.com/pepa65/bulletin`; cd bulletin

#### Autostart
The file `autostart` for the lxsession autostart file needs to be linked in:

`lxconfdir=~/.config/lxsession/LXDE; mkdir -p "$lxconfdir"`
`cp _autostart autostart; ln -sf "$PWD/autostart" "$lxconfdir"`

#### Set URL
`cp _show show`

In `show` put SITE (IP:PORT) inside the single quotes in `SITE=''`
(Suitable IP addresses can be gleaned by: `ip a |grep -o 'inet[^ ]* [^/]*'`.)

* For **bulletin** set the Google slides BASEURL in file `web/index.html`! For CRICS:
   docs.google.com/presentation/d/e/2PACX-1vRvUDuEXVO03r8LiDLhtZHqMpqN1ByvpTYreV27QQdoT9cbZ1-xknPT-D2cYu_o8Cr6ZfsdCLJ167xI
* For **piscreen** set the URL in `show`!**

#### Set screentimes
Add crontab lines to turn the screen on & off at certain times:
`crontab < <(crontab -l; echo -e "\n# Display On at 7:00 Mo-Fr on a schoolday\n"'0 7 * * 1-5' "$HOME/git/bulletin/displ\n\n# Display Off at 17:00 Mo-Fr\n"'0 17 * * 1-5' "$HOME/git/bulletin/displ off\n")`
