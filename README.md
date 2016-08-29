# Wercker to LaMetric

![Alt text](/screenshots/product.gif?raw=true "This how LaMetric looks")

This small app powers the *Wercker Projects Status* application in the *LaMetric* store. The app looks up the last build and deploy results of all the projects you have access to. When checking the build status, only the *master* branch is taken into consideration.

*Wercker* is a Continuous Integration service. It exposes an API that this app uses. As a registered user, you can generate an OAuth2 token from the Wercker interface. You can then use the token when configuring the *Wercker Projects Status* app on your phone.

*LaMatric* is a company providing smart table clocks with customizable display. They expose a visual DSL through which developers can create applications.

## How to set-up the app

![Alt text](/screenshots/tutorial.gif?raw=true "A large download for your viewing pleasure")

* Open *LaMetric* app.
* Select your device.
* Add a new application from the store.
* Search for *Wercker*.
* Install the app.
* Open [https://app.wercker.com/#profile/tokens](https://app.wercker.com/#profile/tokens) in your phone browser.
* Sign in *Wercker* if you're not already logged in.
* Generate a new token and copy it to clipboard.
* Go back to the *LaMetric* app.
* In the configuration options of the *Wercker Projects Status* app add the OAuth2 token from the clipboard
* Add the organization or username coresponding to the token.
* That's it, you're all set. Look further down for the different states of the display.

## States

#### Everything is OK

This is the desired state of your projects.

![Alt text](/screenshots/healthy.gif?raw=true "The green builds")

#### A number of runs are failing

Some of your projects have their last run failing on their *master* branch.

![Alt text](/screenshots/buildonly.gif?raw=true "Something bad on master")

#### A number of deploys are failing

Some of your builds could not be deployed.

![Alt text](/screenshots/deployonly.gif?raw=true "too bad you can't deploy")

#### A number of deploys and builds are failing

This is the situation you do not want to find yourself in.

![Alt text](/screenshots/buildanddeploy.gif?raw=true "Everything is breaking apart.")

#### The app is not configured

You somehow missed the steps above. Look at the *How to set-up the app* section.

![Alt text](/screenshots/configure.gif?raw=true "Not enough configuration")


#### Some unexpected error happened

The server is not responding because of an error. There is probably nothing you can do about it. You'll just have to wait for it to get fixed. You can speed up the process if you submit an issue.

![Alt text](/screenshots/error.gif?raw=true "The green builds")


