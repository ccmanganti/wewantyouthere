<?php

namespace App\Filament\Customer\Resources\Invitations\Pages;

use App\Filament\Customer\Resources\Invitations\InvitationResource;
use Filament\Resources\Pages\ListRecords;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;
}
