# KNNFORPHP

<h1>by BrunoVias</h1>


<h2>this algorithm calculates the KNN based on the euclidean distance.</h2>

<h6>Functions</h6>
<p>__construct("DATASETPATH");</p>
<p>setK(int arg) -> arg: the K number, must be odd.</p>
<p>setNewArtifect([] arg) -> arg: set the information that you want classify.</p>
<p>exec() return -> return the classification of data</p>

HOW TO USE:<br>

<h2>you need a json dataset, this json must have a "class property" in ALL objects:</h2>

```json
EXEMPLE:
{
    "vais" : {
        "pontos" : 7.00,
        "faltas" : 13,
        "class": "Passou"
    },
    "samp" : {
        "pontos" : 10.00,
        "faltas" : 22,
        "class": "Reprovou"
    },
    "bruno" : {
        "pontos" : 8.13,
        "faltas" : 22,
        "class": "Reprovou"
    },
    "joy" : {
        "pontos" : 9.13,
        "faltas" : 18,
        "class": "Passou"
    }
}
```
USE EXEMPLE:
```php
$artefact = [
    'pontos' => 8.6,
    'faltas' => 17
];//the data that you want to classify must have the same properties of the dataset, except the class property.

$knn = new KNN("path/dataset.json"); //here you instance a KNN object.
$knn->setK(3); //here you set de K, you need an odd number.
$knn->setNewArtifect($artefact); //set the information that you want classify.

$classification = $knn->exec();//return the classification of data
echo $classification;
```
