<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Domain\Network\Models\Contact;
use Domain\Network\Repositories\ContactRepository;
use Domain\Network\Services\ContactService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactController extends Controller
{
    public function __construct(
        
    )
    {
        
    }
    public function index(): JsonResource
    {   
       $service = new ContactService(
            new ContactRepository(
                query: Contact::query()->where('user_id',auth()->id()),
                database: resolve(DatabaseManager::class)
            )
       );
       return JsonResource::make($service->all());
    }
}
