# Sulu block bundle

A bundle that allows to manage content block for the SULU CMS.

It is a fork from the https://github.com/Harborn-digital/sulu-block-bundle project.

## 1. Installation
### Composer
```bash
composer require pixeldev/sulu-block-bundle
```

## 2. Usage
### Template
Page template modification (mind to include this element: xmlns:xi="http://www.w3.org/2001/XInclude")
```xml
<!-- app/Resources/templates/pages/default.xml -->
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xmlns:xi="http://www.w3.org/2001/XInclude"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>default</key>

    <view>templates/default</view>
    <controller>SuluWebsiteBundle:Default:index</controller>
    <cacheLifetime>2400</cacheLifetime>

    <meta>
        <title lang="en">Default</title>
        <title lang="nl">Standaard</title>
    </meta>

    <properties>
        <!--
        <section name="highlight">
            <properties>
                <property name="title" type="text_line" mandatory="true">
                    <meta>
                        <title lang="en">Title</title>
                        <title lang="nl">Titel</title>
                    </meta>
                    <params>
                        <param name="headline" value="true"/>
                    </params>

                    <tag name="sulu.rlp.part"/>
                </property>

                <property name="url" type="resource_locator" mandatory="true">
                    <meta>
                        <title lang="en">Resourcelocator</title>
                        <title lang="nl">Adres</title>
                    </meta>

                    <tag name="sulu.rlp"/>
                </property>
            </properties>
        </section>

        <property name="article" type="text_editor">
            <meta>
                <title lang="en">Article</title>
                <title lang="de">Artikel</title>
            </meta>
        </property>-->

        <!-- Choose the same name as using in twig (see next paragraph) -->
        <block name="blocks" default-type="text" minOccurs="0">
            <meta>
                <title lang="en">Content</title>
                <title lang="nl">Inhoud</title>
            </meta>
            <types>
                <xi:include href="sulu-block-bundle://blocks/text.xml"/>
                <xi:include href="sulu-block-bundle://blocks/youtube.xml"/>
            </types>
        </block>

        <!-- Choose the same name as using in twig (see next paragraph) -->
        <block name="banners" default-type="text" minOccurs="0">
            <meta>
                <title lang="en">Banners</title>
            </meta>
            <types>
                <xi:include href="sulu-block-bundle://blocks/text.xml"/>
                <xi:include href="sulu-block-bundle://blocks/youtube.xml"/>
            </types>
        </block>
    </properties>
</template>
```
### Twig
Add blocks to the Twig
```twig
{% block content %}
    <div vocab='http://schema.org/' typeof='Content'>
        <h1 property='title'>{{ content.title }}</h1>

        <div property='article'>
            {{ content.article|raw }}
        </div>

        {% include '@Block/html5-blocks.html.twig' %}
        {% include '@Block/html5-blocks.html.twig' with {element: 'aside', collection: 'banners'} %}
    </div>
{% endblock %}
```
#### Override Twig templates
Create the following structure to override blocks via Twig `templates/bundles/PixelBlockBundle`.
If you wish to override the following block `Resources/views/html5/parts/images.html.twig`, you must create the next file : `templates/bundles/PixelBlockBundle/html5/parts/images.html.twig`. 

And if you only want to replace some of the template blocks in this bundle, you can extend the base template using this namespace `@!Block`. 

For example
```twig
{# templates/bundles/PixelBlockBundle/html5/parts/images.html.twig #}
{% extends "@!Block/html5/parts/images.html.twig" %}

{% block image_source %}{{ image.thumbnails['50x50'] }}{% endblock %}
```

## 3. Available blocks
- Rich text with a title (text)
- Images with a title (images)
- Images with a title and a rich text (image_text)
- Image, title with sub-title and quote (image_title_subtitle_quote)
- Youtube video (youtube)
- Link (link)
- Quote (quote)
- Before/After (image_before_after)
- Twi columns (two_columns)
- Three columns (three_columns)

## 4. Add properties
When you use a block and you want to add additional properties, you can configure them separately in `config/templates/PixelSuluBlockBundle/properties/{blockname}.xml`.

For instance, if you wish to add a caption to the images block, you will create the following fil in you customer application:
```xml
<!-- config/templates/PixelSuluBlockBundle/properties/images.xml -->
<?xml version='1.0' ?>
<properties xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <property name='caption' type='text_line'>
        <meta>
            <title lang='en'>Caption</title>
        </meta>
    </property>
</properties>
```

## 5. Override properties parameters

### 5.1 Completely replace all parameters
When you use a block and you want to choose youself all the parameters to the blocks properties, you can configure them separately in `config/templates/PixelSuluBlockBundle/params/{blockname}.xml`.
For example, if you want to define all the text editor property parameters, you will create the following file in you customer application:
```xml
<!-- config/templates/PixelSuluBlockBundle/params/text_editor.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <param name="link" value="true"/>
    <param name="paste_from_word" value="true"/>
    <param name="height" value="100"/>
    <param name="max_height" value="200"/>
</params>
```

### 5.2 Adjust parameters
When you use a block and you wish to edit parameters to the blocks properties, you can configure them in `config/templates/PixelSuluBlockBundle/params/{blockname}_adjustments.xml`.

For instance, if you want to adjust the height and deactivate the tab feature of the text editor property, you will create the following file in your customer application:
```xml
<!-- config/templates/PixelSuluBlockBundle/params/text_editor_adjustments.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <param name="height" value="200"/>
    <param name="table" value="false"/>
</params>
```

### 5.3 Add parameters

When you use a block and you want to add parameters to the blocks properties, you can separately configure them in `config/templates/PixelSuluBlockBundle/params/{blockname}_additions.xml`.

For instance, if you wish to add the ui_color parameter to the text_editor property, you will create the following file in your customer application:
```xml
<!-- config/templates/PixelSuluBlockBundle/params/text_editor_additions.xml -->
<?xml version='1.0' ?>
<params xmlns='http://schemas.sulu.io/template/template'
    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
    xsi:schemaLocation='http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd'
    >
    <param name="ui_color" value="#ffcc00"/>
</params>
```