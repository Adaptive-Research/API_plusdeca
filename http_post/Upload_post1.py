from requests_toolbelt import MultipartEncoder
import requests

url = 'http://API.test:8011/API/Upload-BusinessCards'



Fichier = '/home/daniel/Téléchargements/BusinessCard.csv'
m = MultipartEncoder(
    fields={'Submit': '1', 'debug': '1', 'token':'12;e0a5e44f67251fc8fb2192d7574e84b1d31c8e52fa34f0125bdbf9eaa9ca',
            'data': (Fichier, open(Fichier, 'rb'), 'text/plain')}
)

x = requests.post(url, data=m,
                  headers={'Content-Type': m.content_type})


print(x.text)

