import requests

url = 'http://API.test:8011/API/Invalidate-Interview'
#url = 'http://plusdeca.api2/API/Show-Interviews-For-User'



#myobj = [ ('Submit' , '1'), ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22')  ]
myobj = [ ('Submit' , '1'), ( 'debug' , '1' ) , ('token', '12;e0a5e44f67251fc8fb2192d7574e84b1d31c8e52fa34f0125bdbf9eaa9ca'), ( 'idInterview' , '1' )  ]

x = requests.post(url, data = myobj)
print(x.text)

