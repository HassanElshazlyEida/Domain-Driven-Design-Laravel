<?php

namespace Domain\Subscriber\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Illuminate\Validation\Rule;
use Domain\Subscriber\Models\Tag;
use Domain\Subscriber\Models\Form;
use Spatie\LaravelData\DataCollection;
use Domain\Subscriber\DataTransferObjects\TagData;

class SubscriberData extends Data
{
    public function __construct(
        public readonly ?int            $id,
        public readonly string          $email,
        public readonly string          $first_name,
        public readonly ?string         $last_name,
        /** @var DataCollection<TagData> */
        public readonly ?DataCollection $tags,
        public readonly ?FormData       $form,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {

        return self::from([
            ...$request->all(),
            'tags' => TagData::collect(Tag::whereIn('id', $request->collect('tag_ids'))->get()),
            'form' => FormData::from(Form::findOrNew($request->form_id)),
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