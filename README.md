# piscreen
**Displaying a webpage on a screen by a Raspberry Pi**

# bulletin
**Running a Google slide show on a screen attached to a Raspberry Pi**

* Required: chromium-browser unclutter xdotool lxsession(Raspbian)
* Repo: https://gitlab.com/pepa65/bulletin
* For 'bulletin': a Google slides base URL (see `web/index.html`, the part
  after `src="` and before `/embed?`)

## Install

### Raspberry OS
Install Raspberry OS. Use `raspi-config` to configure the wireless connection.
Enabling an ssh server is recommended for remote access.

### Screen
Configure the screen resolution with `raspi-config` (Advanced, Resolution).
If the display needs to be rotated, add a line like this to `/boot/config.txt`:

`display_hdmi_rotate 3`

(Using `3` rotates the display 90 degrees counter-clockwise and `1` clockwise).

If there is overscan (content not aligning well with screen edges), the
`setoverscan` tool can be used from https://github.com/pepa65/setoverscan

### Application

All the following can be done with 1 command, installing either 'bulletin'
or 'piscreen':

1. `bash INSTALL` # Installing 'bulletin'
2. `bash INSTALL 'https://aqi.crics.asia'` # Installing 'piscreen' for URL

### Manual Install

#### Packages
Install all the required packages:

`apt install git chromium-browser unclutter xdotool lxsession`

#### Hosts
Add the external IP address to `/etc/hosts` by adding a line like:

`<ip-address> bulletin`

(Suitable IP addresses can be gleaned by: `ip a |grep -o 'inet[^ ]* [^/]*'`.)

Only necessary when displaying local pages, for sure for 'bulletin'.

#### Download
Clone the git repo:

`mkdir ~/git; cd ~/git; git clone https://gitlab.com/pepa65/bulletin`

#### Autostart
The file `autostart` for the lxsession autostart file needs to be linked in:

`lxconfdir=~/.config/lxsession/LXDE; mkdir -p "$lxconfdir"`
`cp autostart autostart_; ln -sf "$PWD/autostart_" "$lxconfdir"`


#### Set URL
**For 'bulletin' set the Google slides base URL in `web/index.html`!**

**For 'piscreen' set the URL in `autostart_`!**

#### Set screentimes
Add crontab lines to turn the screen on & off at certain times:
`crontab < <(crontab -l; echo -e "\n# Display maybe On at 7:30 Mo-Fr\n"'30 7 * * 1-5' "$HOME/git/bulletin/displ\n\n# Display Off at 17:00 Mo-Fr\n"'0 17 * * 1-5' "$HOME/git/bulletin/displ off\n")`
