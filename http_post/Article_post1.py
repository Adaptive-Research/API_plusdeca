import requests

#url = 'http://API.test:8011/API/Creer-Article'
url = 'http://plusdeca.api2/API/Creer-Article'



myobj = [ ('Submit' , '1'), ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'Article_Title' , 'test' ) , ( 'Article_Text' , 'test1 dflkdsaf  fdjslgfjds lgj gfjdklsgjlfds jklgfdjglkfds gk;fds ;gpoirewit ' ) ]

x = requests.post(url, data = myobj)
print(x.text)

