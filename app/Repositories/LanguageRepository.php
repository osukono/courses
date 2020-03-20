<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use App\User;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LanguageRepository
{
    protected Language $model;

    /**
     * LanguageRepository constructor.
     * @param Language $language
     */
    public function __construct(Language $language)
    {
        $this->model = $language;
    }

    /**
     * @param $id
     * @return LanguageRepository
     */
    public static function find($id)
    {
        return Language::findOrFail($id)->repository();
    }

    /**
     * @return Builder|Language
     */
    public static function all()
    {
        return Language::query();
    }

    /**
     * @param array $attributes
     * @return Language
     */
    public static function create(array $attributes)
    {
        $language = new Language();
        $language->name = $attributes['name'];
        $language->native = $attributes['native'];
        $language->code = $attributes['code'];
        $language->save();

        return $language;
    }

    public function createFirestoreDocument()
    {
        $firebase = Firebase::getInstance()->firestoreClient();

        $snapshot = $firebase->collection(Firebase::languages_collection)
            ->where('code', '=', $this->model->code)
            ->limit(1)
            ->documents();

        if ($snapshot->isEmpty()) {
            $reference = $firebase->collection(Firebase::languages_collection)->add([
                'code' => $this->model->code,
                'name' => $this->model->native,
            ]);

            $this->model->firebase_id = $reference->id();
        } else {
            $this->model->firebase_id = $snapshot->rows()[0]->id();
        }

        $this->model->save();
    }

    /**
     * @param array $attributes
     */
    public function update(array $attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->native = $attributes['native'];
        $this->model->code = $attributes['code'];
        $this->model->firebase_id = $attributes['firebase_id'];
        $this->model->slug = null;
        $this->model->save();
    }

    public function updateFirestoreDocument()
    {
        if (empty($this->model->firebase_id))
            return;

        $firestore = Firebase::getInstance()->firestoreClient();
        $firestore->collection(Firebase::languages_collection)->document($this->model->firebase_id)
            ->set([
                'code' => $this->model->code,
                'name' => $this->model->native
            ], ['merge' => true]);
    }

    /**
     * @param Request $request
     * @throws FileNotFoundException
     */
    public function uploadIcon(Request $request)
    {
        if (!isset($this->model->firebase_id))
            return;

        $icon = Firebase::getInstance()->uploadFile($request->file('icon'), 'languages');

        $this->model->icon = $icon;
        $this->model->save();

        $firestore = Firebase::getInstance()->firestoreClient();
        $firestore->collection(Firebase::languages_collection)->document($this->model->firebase_id)
            ->set([
                'icon' => $this->model->icon
            ], ['merge' => true]);
    }

    /**
     * @throws Exception
     */
    public function syncWithFirestore()
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        $languagesSnapshot = $firestore->collection(Firebase::languages_collection)
            ->where('code', '=', $this->model->code)
            ->limit(1)
            ->documents();

        if ($languagesSnapshot->isEmpty()) {
            throw new Exception('Firestore does not have language with code ' . $this->model->code);
        }

        $firestoreLanguage = $languagesSnapshot->rows()[0];

        $this->model->firebase_id = $firestoreLanguage->id();

        $data = $firestoreLanguage->data();
        $this->model->native = Arr::get($data, 'name', '');
        $this->model->icon = Arr::get($data, 'icon', null);
        $this->model->save();
    }

    /**
     * @throws Exception
     */
    public function destroy()
    {
        $this->model->delete();
    }

    /**
     * @param User $user
     */
    public function assignEditor(User $user)
    {
        $this->model->editors()->syncWithoutDetaching($user);
    }

    /**
     * @param User $user
     */
    public function removeEditor(User $user)
    {
        $this->model->editors()->detach($user);
    }

    /**
     * @return Language
     */
    public function model()
    {
        return $this->model;
    }
}
