<?php

namespace App\Models;

class Topic extends Model
{
  protected $fillable = ['title', 'body', 'category_id','excerpt', 'slug'];

  //与分类一对一关联
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  //与用户一对一关联
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  //排序逻辑
  public function scopeWithOrder($query, $order)
  {
    // 不同的排序，使用不同的数据读取逻辑
    switch ($order) {
      case 'recent':
        $query->recent();
        break;

      default:
        $query->recentReplied();
        break;
    }
    // 预加载防止 N+1 问题
    return $query->with('user', 'category');
  }

  public function scopeRecentReplied($query)
  {
    // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
    // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
    return $query->orderBy('updated_at', 'desc');
  }

  public function scopeRecent($query)
  {
    // 按照创建时间排序
    return $query->orderBy('created_at', 'desc');
  }


  //Slug SEO 路由优化
  public function link($params = [])
  {
      //参数 $params 允许附加 URL 参数的设定
      return route('topics.show',array_merge([$this->id,$this->slug],$params));
  }

}
