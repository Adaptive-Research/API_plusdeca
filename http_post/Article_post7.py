import requests

url = 'http://API.test:8011/API/Validate-Article'



myobj = [ ('Submit' , '1'), ('debug' , '1'),  ('token', '12;e0a5e44f67251fc8fb2192d7574e84b1d31c8e52fa34f0125bdbf9eaa9ca') , ('id','1' ) ]

x = requests.post(url, data = myobj)
print(x.text)

