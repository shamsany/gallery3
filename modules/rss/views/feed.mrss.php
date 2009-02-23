<?php defined("SYSPATH") or die("No direct script access.") ?>
<? echo "<?xml version=\"1.0\" ?>" ?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/"
   xmlns:atom="http://www.w3.org/2005/Atom"
   xmlns:content="http://purl.org/rss/1.0/modules/content/"
   xmlns:fh="http://purl.org/syndication/history/1.0">
  <channel>
    <generator>gallery3</generator>
    <title><?= htmlspecialchars($title) ?></title>
    <link><?= $link ?></link>
    <description><?= htmlspecialchars($description) ?></description>
    <language>en-us</language>
    <atom:link rel="self" href="<?= $feed_link ?>" type="application/rss+xml" />
    <fh:complete/>
    <? if (!empty($previous_page_link)): ?>
    <atom:link rel="previous" href="<?= $previous_page_link ?>" type="application/rss+xml" />
    <? endif ?>
    <? if (!empty($next_page_link)): ?>
    <atom:link rel="next" href="<?= $next_page_link ?>" type="application/rss+xml" />
    <? endif ?>
    <pubDate><?= $pub_date ?></pubDate>
    <lastBuildDate><?= $pub_date ?></lastBuildDate>
    <? foreach ($children as $child): ?>
    <item>
      <title><?= htmlspecialchars($child->title) ?></title>
      <link><?= url::abs_site("{$child->type}s/{$child->id}") ?></link>
      <guid isPermaLink="true"><?= url::abs_site("{$child->type}s/{$child->id}") ?></guid>
      <pubDate><?= date("D, d M Y H:i:s T", $child->created); ?></pubDate>
      <content:encoded>
        <![CDATA[
          <span><?= $child->description ?></span>
          <p>
          <? if ($child->type == "photo" || $child->type == "album"): ?>
            <img alt="" src="<?= $child->resize_url(true) ?>"
                 title="<?= htmlspecialchars($child->title) ?>"
                 height="<?= $child->resize_height ?>" width="<?= $child->resize_width ?>" /><br />
          <? else: ?>
            <a href="<?= url::abs_site("{$child->type}s/{$child->id}") ?>">
            <img alt="" src="<?= $child->thumb_url(true) ?>"
                 title="<?= htmlspecialchars($child->title) ?>"
                 height="<?= $child->thumb_height ?>" width="<?= $child->thumb_width ?>" /></a><br />
          <? endif ?>
            <?= $child->description ?>
          </p>
        ]]>
      </content:encoded>
      <media:thumbnail url="<?= $child->thumb_url(true) ?>"
                       fileSize="<?= filesize($child->thumb_path()) ?>"
                       height="<?= $child->thumb_height ?>"
                       width="<?= $child->thumb_width ?>"
                       />
      <media:group>
        <? if ($child->type == "photo" || $child->type == "album"): ?>
          <media:content url="<?= $child->resize_url(true) ?>"
                         fileSize="<?= filesize($child->resize_path()) ?>"
                         type="<?= $child->mime_type ?>"
                         height="<?= $child->resize_height ?>"
                         width="<?= $child->resize_width ?>"
                         isDefault="true"
                         />
          <? if (access::can("view_full", $child)): ?>
            <media:content url="<?= $child->file_url(true) ?>"
                           fileSize="<?= filesize($child->file_path()) ?>"
                           type="<?= $child->mime_type ?>"
                           height="<?= $child->height ?>"
                           width="<?= $child->width ?>"
                           />
          <? endif ?>
        <? else: ?>
          <media:content url="<?= $child->file_url(true) ?>"
                         fileSize="<?= filesize($child->file_path()) ?>"
                         height="<?= $child->height ?>"
                         width="<?= $child->width ?>"
                         type="<?= $child->mime_type ?>"
                         />
        <? endif ?>
      </media:group>
    </item>
    <? endforeach ?>
  </channel>
</rss>
