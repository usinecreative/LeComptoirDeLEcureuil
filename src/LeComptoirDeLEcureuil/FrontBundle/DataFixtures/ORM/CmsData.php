<?php

namespace LeComptoirDeLEcureuil\FrontBundle\DataFixtures\ORM;

use BlueBear\CmsUserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CmsData extends FixturesBase implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $user = $this->loadUsers();
        $this->loadCategories($user);
        $this->manager->flush();
    }

    protected function loadUsers()
    {
       return $this->loadUser('Salveena', 'admin', $this->container->getParameter('default_mail'));
    }

    protected function loadCategories(User $user)
    {
        $category = $this->loadCategory('Littérature', 'litterature', true);
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );
        $this->loadArticle(
            'La Petite Mort – Davy Mourier',
            '<p style="text-align: justify;"><em>La Petite Mort vit des jours heureux avec Papa et Maman Mort. Il va à l’école, tombe amoureux d’une fille de sa classe et essaie de se faire des amis. Bref, à quelques détails près, la Petite Mort est un enfant comme les autres, si ce n’est qu’il a un avenir tout tracé : quand il sera grand, il reprendra le travail de Faucheuse de son père. Ce qui tombe mal, car la Petite Mort veut être fleuriste !</em></p>
<p style="text-align: justify;"><strong>La Petite Mort</strong> est un enfant presque comme les autres, si l’on excepte son accoutrement un poil morbide et son ascendance peu fréquentable, La Camarde... Un avenir tout tracé et difficile à accepter lui est promis. Mais La Petite Mort est tout sauf emballé par ce futur. Elle veut devenir fleuriste quand elle sera plus grande. (J\'avoue que si la Mort me tend des fleurs, je suis pas sûre de les prendre. Mais enfin...)<!--more-->
Par petits sketchs, le lecteur suit le quotidien de La Petite Mort à l\'école, chez lui entouré de ses parents, avec son petit chat nommé <strong>Sephi</strong> et surtout son apprentissage de future faucheuse (entre accidentés et maison de retraire, il y a du boulot !). Mais La Petite Mort avec ses interrogations et son comportement, reste un enfant comme les autres, ce qui le rend attachant. Personnellement, je trouve qu\'il y a beaucoup de mélancolie et de tendresse qui transparait à travers les échanges de notre petit héros et de son entourage. La Petite Mort en fréquentant l\'école, se retrouvera rejetée par presque tous les enfants à cause de son physique et de son parler, on ne peut plus direct (phénomène étonnamment banal et triste (parfois dramatique) que l\'on retrouve entre enfants humains, dès lors que l\'on est différent). Comble de l’ironie, c’est un camarade malade qui se liera à lui :</p>
<p style="text-align: justify;"><em>« - Moi, je veux bien être ton ami. Il faut cultiver la différence plutôt que d\'en avoir peur. Si tu veux, après l\'école je te raccompagne chez toi.</em>
<em>- Non! C\'est toi qui a la leucémie ... et je ne ramène jamais de travail à la maison. »</em></p>
<p style="text-align: justify;">Si l\'on rit beaucoup au fil des pages, certains gags plus sombres évoquent des situations dramatiques auxquelles tout un chacun peut-être confronté (ou a été confronté) et nous montrent la mort dans ce qu\'elle a de plus humain. <strong>Davy Mourier</strong>, à travers ses sketchs et parodies grinçantes (et parfois franchement émouvantes), fait toujours mouche. De nombreuses références à notre société se sont glissées dans les bulles, tout en ayant subit un petit changement approprié à l’univers de <strong>Davy Mourier</strong>. C’est ainsi que La Petite Mort possède un sac « Hello Kittu ».
Drôle et déroutant, ce livre ravira les amateurs d’humour noir et décalé.</p>
<p style="text-align: justify;"><a href="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png"><img class="aligncenter wp-image-976 size-full" src="http://lecomptoirdelecureuil.fr/wp-content/uploads/2015/03/strip.png" alt="strip" width="1007" height="508" /></a></p>
<p style="text-align: justify;">Le mot de la fin : Youpi! Y\'a en fait 2 tomes! (Et tout ça aux <strong>Éditions Delcourt</strong>)</p>
[gallery columns="2" ids="970,969"]
<p style="text-align: justify;"></p>',
            'la-petite-mort',
            $category,
            $user
        );

        $this->loadCategory('Manga/BD', 'manga-bd', true);
        $this->loadCategory('Sorties', 'sorties', true);
        $this->loadCategory('Rencontres', 'rencontres', true);
    }
}
