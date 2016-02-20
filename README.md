# Wercker to LaMetric

![Alt text](/screenshots/product.gif?raw=true "This how LaMetric looks")

This small app powers the *Wercker Projects Status* application in the *LaMetric* store. Provided with a *token* and an *username/organization*, it will look up the last build and deploy results of all the projects you have access to. When checking the build status, the app currently looks at the *master* branch only.

*Wercker* is a Continuous Integration service. It exposes an API that this app uses. As a registered user, you can generate an OAuth2 token from the Wercker interface. You can then use the token when configuring the *Wercker Projects Status* app on your phone.

*LaMatric* is a company providing smart table clocks with customizable display. They expose a visual DSL through which developers can configure small applications.

## How to set-up the app

![Alt text](/screenshots/tutorial.jpg?raw=true "A large download for your viewing pleasure")