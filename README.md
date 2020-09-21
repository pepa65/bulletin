# bulletin
**Running a editable bulletin page on a screen attached to a Raspberry Pi**

* Required: chromium-browser php-fpm unclutter lxsession(Raspberry OS)
* Repo: gitlab.com/pepa65/bulletin

## Install
### Screen
Configure the screen with `raspi-config` (Advanced, Resolution)
If the display needs to be rotated, add a line like this to `/boot/config.txt`:
`display_hdmi_rotate 1`  (Rotate 90 degrees clockwise, 3 is counter-clockwise)

### Autostart
The file `autostart` contains the content of the lxsession autostart file
`/etc/xdg/lxsession/LXDE-pi/autostart`:
```
@lxpanel --profile LXDE
#@pcmanfm --desktop --profile LXDE
#@xscreensaver -no-splash
@unclutter -idle 0
@xset s off
@xset -dpms
@xset s noblank
@php -S localhost:8888 -t "$HOME/git/bulletin" &
@chromium-browser --noerrdialogs --incognito \
	--kiosk http://localhost:8888/index.html \
	--check-for-update-interval=31536000
```

This should be copied to `/etc/xdg/lxsession/LXDE/autostart`:
`cp autostart /etc/xdg/lxsession/LXDE/autostart`
