
### Ajout de champs dans une Entity

 1. modifier l'entité

Par exemple :
```
    /**
     * @var boolean
     *
     * @ORM\Column(name="mamaEvent", type="boolean")
     */
    private $mamaEvent;
```

 2. mettre à jour le schéma

```
$ php bin/console doctrine:schema:update --force
```