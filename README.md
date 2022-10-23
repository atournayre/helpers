# Helpers

Ce composant met à disposition des classes pour accélérer les développements.

Ce composant utilise Symfony.

## Installation
### Composer
```shell
composer require atournayre/helpers
```

## Que contient il ?
| Type                      | Description                                                                                   |
|---------------------------|-----------------------------------------------------------------------------------------------|
| AbstractExceptionListener | Classe abstraite fournissant des méthodes pour faciliter le traitement des exceptions Kernel. |
| Controller                | Etend AbstractController et fourni des méthodes explicites.                                   |
| EnumExtension             | Fourni une méthode de récupération de valeur pour les Enums.                                  |
| FlashMessageHelper        | Fourni des constantes et des messages courants.                                               |
| FlashService              | Fourni des méthodes pour créer des flash messages.                                            |
| JsonResponseHelper        | Fourni des méthodes pour préparer les données des réponses json.                              |
| TypedException            | Lance des exceptions typées.                                                                  |

## Configuration
### FlashService
```yaml
# config.services.yaml
services:
    Atournayre\Helper\Service\FlashService:
        class: Atournayre\Helper\Service\FlashService
        # La section argument est inutile si l'autowiring est activé 
        arguments:
          - '@request_stack'
```

### EnumExtension
Pour activer l'extension.
```yaml
# config.services.yaml
services:
    Atournayre\Helper\Twig\Extension\EnumExtension:
      class: Atournayre\Helper\Twig\Extension\EnumExtension
```
