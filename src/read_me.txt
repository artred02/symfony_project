Ce projet est en fait proche de l'ancien, en effet il reprend cette histoire de pièces d'ordinateurs mais cette fois en symfony.

Le style a été fait très succintement en boostrap.

Pour ce qui est de l'entité user, un utilisateur est obligé d'avoir un compte créé depuis le /register puis d'être authenticate avec la connection.

Un utilisateur ne possédant pas de role admin ne pourra pas ajouter ou modifier d'items tandis qu'un admin (possédant 'ROLE_ADMIN') pourra le faire.

J'ai créé une commande permettant de modifier le rôle de qqu dans l'invite de commande avec php bin/cocnsole app:user:promote <username> <role>
exemple : php bin/console app:user:promote 'test' 'ROLE_ADMIN'
(pratique au cas où plus personne n'est administrateur)

Le access denied handler permet de catch les access denied lorsqu'un utilisateur ne possédant pas le role admin essaye d'avoir accès à une page admin.
Il redirige automatiquement la personne.

Mes controlleurs sont séparés par view. En effet tout ce qui se passe dans une vue est controllé par un seul controlleur. Celà permet d'aller de suite chercher le bon controlleur.

Le printer sert à afficher les items d'où son nom.


Pour utiliser ls site, il faut ajouter la base de donnée avec le .env et pour ce qui est des compte, il faut en créer un puis le passer en admin ou utiliser ceux déjà présents en bdd.
Il existe le compte oui qui est admin avec username : 'oui' et mdp : 'ouioui'

Sinon il est possible d'utiliser la commande pour passer le compte en admin comme expliqué plus haut.