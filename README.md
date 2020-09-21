# bulletin
**Running a editable bulletin page on a screen attached to a Raspberry Pi**

* Required: chromium-browser php-fpm unclutter lxsession(Raspberry OS)
* Repo: gitlab.com/pepa65/bulletin

## Install

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
`crontab < <(crontab -l; echo "@reboot /home/pi/git/startweb")`
