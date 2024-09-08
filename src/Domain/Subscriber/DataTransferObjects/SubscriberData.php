<?php

namespace Domain\Subscriber\DataTransferObjects;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Illuminate\Validation\Rule;
use Domain\Subscriber\Models\Tag;
use Domain\Subscriber\Models\Form;
use Spatie\LaravelData\DataCollection;
use Domain\Subscriber\Models\Subscriber;
use Spatie\LaravelData\Attributes\WithCast;
use Domain\Subscriber\DataTransferObjects\TagData;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class SubscriberData extends Data
{
    public function __construct(
        public readonly ?int            $id,
        public readonly string          $email,
        public readonly string          $first_name,
        public readonly ?string         $last_name,
        public readonly ?string         $full_name,
        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d H:i:s")]
        public readonly ?Carbon         $subscribed_at,
        /** @var DataCollection<TagData> */
        public readonly null|Lazy|DataCollection    $tags,
        public readonly null|Lazy|FormData          $form,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
      
        return self::from([
            ...$request->all(),
            'tags' => TagData::collection(Tag::whereIn('id', $request->collect('tag_ids'))->get()),
            'form' => FormData::from(Form::findOrNew($request->form_id)),
        ]);
    }
    public static function fromModel(Subscriber $subscriber): self
    {
        return self::from([
            ...$subscriber->toArray(),
            'tags' => Lazy::whenLoaded('tags', $subscriber, fn () => TagData::collection($subscriber->tags)),
            'form' => Lazy::whenLoaded('form', $subscriber, fn () => ($subscriber->form?->id ?? null)?FormData::from($subscriber->form):null),
            'full_name' => $subscriber->full_name,
        ]);
    }
    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email')->ignore(request('subscriber')),
            ],
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'sometimes', 'string'],
            'tag_ids' => ['nullable', 'sometimes', 'array'],
            'form_id' => ['nullable', 'sometimes', 'exists:forms,id'],
        ];
    }
}