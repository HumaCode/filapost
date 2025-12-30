<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Enums\PostStatusEnum;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function countPostsByStatus($status = 'all')
    {
        $posts = Post::where(function ($query) {
            if (!auth()->user()->canAny(['Post View', 'Post Edit', 'Post Delete'])) {
                $query->where('user_id', auth()->id());
            }
        });

        if ($status == 'all') {
            return $posts->count();
        }

        return $posts->where('status', $status)->count();
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->badge($this->countPostsByStatus())
                ->badgeColor('primary'),
            'draft' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', PostStatusEnum::Draft))
                ->badge($this->countPostsByStatus(PostStatusEnum::Draft))
                ->badgeColor('gray'),
            'reviewing' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', PostStatusEnum::Reviewing))
                ->badge($this->countPostsByStatus(PostStatusEnum::Reviewing))
                ->badgeColor('info'),
            'published' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', PostStatusEnum::Published))
                ->badge($this->countPostsByStatus(PostStatusEnum::Published))
                ->badgeColor('success'),
            'rejected' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', PostStatusEnum::Rejected))
                ->badge($this->countPostsByStatus(PostStatusEnum::Rejected))
                ->badgeColor('danger'),
        ];
    }
}
