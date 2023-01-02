import requests

url = 'http://API.test:8011/API/Show-Infos-Utilisateur'
url = 'http://PlusDeCA.api2/API/Show-Infos-Utilisateur'
#url = 'http://78.249.128.56:8011/API/Show-Infos-Utilisateur' 

myobj = [ ('Submit' , '1') , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22') , ('idUser','1')  ]

x = requests.post(url, data = myobj)
print(x.text)

