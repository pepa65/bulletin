# bulletin
**Running a editable bulletin page on a screen attached to a Raspberry Pi**

* Required: chromium-browser php-fpm unclutter lxsession(Raspberry OS)
* Repo: gitlab.com/pepa65/bulletin

## Install

### Raspberry OS
Install Raspberry OS. Use `raspi-config` to configure the wireless connection.
Enabling an ssh server is recommended for remote access. Remote editing of the
screen contents is the main idea, so the device needs to be accessible from the
network. Find the IP address with `ip a`. Add this line to `/etc/hosts`:

<ip-address>` bulletin`

This allows the usage of `bulletin` to serve the files on.

### Download
`mkdir ~/git; cd ~/git; git clone https://gitlab.com/pepa65/bulletin`

### Screen
Configure the screen resolution with `raspi-config` (Advanced, Resolution).
If the display needs to be rotated, add a line like this to `/boot/config.txt`:

`display_hdmi_rotate 3`

Rotate display 90 degrees counter-clockwise with '3' ('1' is clockwise).

### Autostart
The file `autostart` for the lxsession autostart file needs to be put in place:

`lx=~/.config/lxsession/LXDE; mkdir -p "$lx"; cp autostart "$lx"`

Cron needs to be set up to start the webserver on reboot:

`crontab < <(crontab -l; echo "@reboot $HOME/git/bulletin/websrv")`

Cron needs to be set up to get the AQI every 5 minutes:

`crontab < <(crontab -l; echo '*/5 * * * *' "$HOME/git/bulletin/getaqi")`
