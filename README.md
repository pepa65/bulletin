# bulletin
**Running a Google slide show on a screen attached to a Raspberry Pi**

* Required: git chromium-browser unclutter xdotool lxsession(Raspbian) php-fpm
* Repo: https://gitlab.com/pepa65/bulletin

## Install

### Raspberry OS
Install Raspberry OS. Use `raspi-config` to configure the wireless connection.
Enabling an ssh server is recommended for remote access.

Install all the required packages:
`apt install git chromium-browser unclutter xdotool lxsession`

Add either a local (like 127.x.x.x) or an external IP address to`/etc/hosts`:

`<ip-address> bulletin`

### Download
`mkdir ~/git; cd ~/git; git clone https://gitlab.com/pepa65/bulletin`

### Screen
Configure the screen resolution with `raspi-config` (Advanced, Resolution).
If the display needs to be rotated, add a line like this to `/boot/config.txt`:

`display_hdmi_rotate 3`

Rotate display 90 degrees counter-clockwise with '3' ('1' is clockwise).

If there is overscan (content not aligning well with screen edges), the
`setoverscan` tool can be used from https://github.com/pepa65/setoverscan

### Autostart
The file `autostart` for the lxsession autostart file needs to be put in place:

`lx=~/.config/lxsession/LXDE; mkdir -p "$lx"; cp autostart "$lx"`

Cron needs to be set up to get the AQI every 5 minutes
(this requires https://aqi.crics.asia to work!):

`crontab < <(crontab -l; echo '*/5 * * * *' "$HOME/git/bulletin/getaqi")`

Add crontab lines to turn the screen on & off at certain times:
`crontab < <(crontab -l; echo -e "\n# Display maybe On at 7:30 Mo-Fr\n"'30 7 * * 1-5' ""$HOME/git/bulletin/displ\n\n# Display Off at 17:30 Mo-Fr\n"'0 17 * * 1-5' ""$HOME/git/bulletin/displ off\n")`
