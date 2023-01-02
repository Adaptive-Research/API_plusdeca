import requests

#url = 'http://78.249.128.56:8011/API/Login'
#url = 'http://API.test:8011/API/Login'
url = 'http://plusdeca.api2/API/Login'



print(url)
myobj = [ ('Submit' , '1') , {'debug','1'} , ( 'Email' , 'test@gmail.com' ),  ( 'Password' , 'test' ) ]

x = requests.post(url, data = myobj)
print(x.text)

