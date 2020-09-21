# bulletin
**Running a editable bulletin page on a screen attached to a Raspberry Pi**

* Required: chromium-browser php-fpm unclutter lxsession(Raspberry OS)

## Install
The file `autostart` contains the content of the lxsession autostart file
`/etc/xdg/lxsession/LXDE-pi/autostart`:
```
@lxpanel --profile LXDE
#@pcmanfm --desktop --profile LXDE
@unclutter -idle 0
@xset s off
@xset -dpms
@xset s noblank
@php -S localhost:8888 -w "$HOME/git/bulletin"
@chromium-browser --noerrdialogs --incognito --kiosk http://localhost:8888 \
	--check-for-update-interval=31536000
```

This should be copied/appended to `/etc/xdg/lxsession/LXDE-pi/autostart`:
`cp autostart /etc/xdg/lxsession/LXDE-pi/autostart`
