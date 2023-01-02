import requests

#url = 'http://API.test:8011/API/Creer-Infos-Utilisateur'
url = 'http://PlusDeCA.api2/API/Delete-Infos-Utilisateur'

myobj = [ ('Submit' , '1') ,('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22') ,  ( 'idUtilisateur' , '1' )]

x = requests.post(url, data = myobj)
print(x.text)

