# CMSperso
Create to learn PHP

**Bonjour**

Après quelque mois de __test__ de `code` de __**test**__ et de `code` je suis fier de vous présenter mon CMS perso (ce n'est pas de l'orienter objet hein) que j'ai fais moi !! **il faut juste attendre l'arriver de tout les fichiers** 

Il est... enfin **presque...** complet la liste des ajout a faire par la suite :

1. l'ajout de fonctions comme sujet brûlant, ou encore résolut, épinglé etc... pour les forums.
2. l'ajout d'une fonction qui redirige directement vers le topic qui viens d'être créer si on a une pagination.
3. l'ajout d'une pagination sur la liste des articles, forum, catégories etc... en cas de long liste dans l'administration.
4. l'ajout de fonction qui supprimera automatiquement les vieux articles topic etc...
5. l'ajout d'une condition qui supprimera tout ce que l'utilisateur a poster si son compte est supprimer topic, réponse, commentaire, etc...
6. L'ajout d'une fonction qui supprime les commentaire parent et enfant directement sur la page post sans passer par l'administration. 
7. l'ajout de correction mineur sur les thèmes de base.
8. l'ajout peut être d'une vrai administrations séparé.
9. l'ajout d'un ordre pour la liste des forum pas du tout important !!
10. l'ajout bien plus tard d'un système de cache
11. correction d'un bug qui ne supprime pas toutes les images liée a un article  

__Et d'autre choses__ 

Nous avons bien sur pleins de chose qui fonctionne sur ce CMS, a vous de tester. 
mais comme je boss dessus seul je n'ai pas forcément pu tester chaque faille qui pourrait exister je vous laisse me faire un listing des problème avec une **solution** (si vous la connaissez) et si vous ajoutez des modif de fonction ou correction faite en le partage :) .

Le site en entier utilise un éditeur [markdown](http://www.codingdrama.com/bootstrap-markdown/) il faut installer deux js séparé pour que les prévisualisation fonction, j'utilise un [parser](https://github.com/erusev/parsedown) ainsi que [HTMLprifier](http://htmlpurifier.org/) pour vous simplifier l'édition.

J'utilise de plus [google-prettify](https://github.com/google/code-prettify)

Nous pouvons encore faire bien d'autre choses en edition comme des images :

![google-logo](https://www.google.fr/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png)

Ou des blockquote :

> Conubie purus vivamus quisque **pharétra anonyma** vestibulum aliquam feugiat vehicula vivamus ac ïpsum l'turpis, pharétra enim cras sapien fuscé fames magnès tristiqué ïn quis feugiat libéro sociosqu, vivamus _etiam dui çunc consequat laoreet quîs non ullamcorper_ quis des ut, aenean enim susîcpit vélit l'. Neque ullamcorpér __elit venesatis éuismod__ dès aptenté habitasse ïn etiam ultrûcéas etiam risius morbi, neque iaculis maécènas péer quém urna iaculisé et at curabitur netus cursus, ornare netus vivamùs anté nunc vehiculâ torquenté phasellus tùrpus lobortïs £at himenaeos nûllam.

Les fameux titre :

#titre h1
##titre h2
###titre h3

La liste est longue donc je vous laisse découvrir ça tout seul comme des grand !!

Vous pouvez passer sur le fichier install.php pour installer le tout sur une base de donnée MYSQL, avec l'installation vous pourez créer un compte et utiliser le cms tout de suite.

Vous pouvez passer par mon [twitter](https://twitter.com/SkaalZealot?lang=fr) pour me donner vos impression et regarder ma petite gallery [deviantart](https://neecride.deviantart.com) 

Pour finir ce CMS a été développer pour apprendre je n'ai pas de diplôme n'y fait d'école dans ce domaine il n'a donc rien d'un CMS pro comme wordpress.

Vous devrez télécharger certaine librairies vous même comme HTMLpurifier j'indiquerais l'endroit avec un readme.

Le mots de la fin :

**Et n'oubliez pas quand développement comme dans la vie on apprend tout les jours !!!**
