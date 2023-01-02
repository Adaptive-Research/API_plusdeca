import requests

url = 'http://API.test:8011/API/Show-Interviews-For-User'
#url = 'http://plusdeca.api2/API/Show-Interviews-For-User'



#myobj = [ ('Submit' , '1'), ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22')  ]
myobj = [ ('Submit' , '1'), ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'idUtilisateur' , '12' )  ]

x = requests.post(url, data = myobj)
print(x.text)

