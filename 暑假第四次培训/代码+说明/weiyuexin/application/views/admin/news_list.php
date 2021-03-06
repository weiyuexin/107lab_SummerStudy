<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo base_url() . 'style/admin/' ?>css/public.css" />
	<title>Document</title>
</head>
<body>
	<table class="table">
		<tr>
			<td class="th" colspan="10">查看新闻公告列表</td>
		</tr>
		<tr>
			<td id='head'>序号</td>
			<td id='head'>标题</td>
			<td id='head'>发布时间</td>
			<td id='head'>操作</td>
		</tr>

		<?php foreach($news as $v):  ?>
		<tr>
			<td><?php echo $v['id'] ?></td>
			<td class="title"><a href="<?php echo site_url('index/content/news_content/' . $v['id']) ?>" target="_black"><?php echo $v['title'] ?></a></td>
			<td><?php echo date("Y-m-d H:i:s",$v['addtime']) ?></td>
			<td>
				[<a href="<?php echo site_url('admin/news/edit_news/' . $v['id']) ?>">编辑</a>]
				[<a href="<?php echo site_url('admin/news/del/' . $v['id']) ?>">删除</a>]
				[<a href="">置顶</a>]
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<div class="page">
		<?php echo $links ?>
	</div>
</body>
</html>