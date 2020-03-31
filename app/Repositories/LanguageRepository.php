<?php


namespace App\Repositories;


use App\Language;
use App\Library\Firebase;
use App\User;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function uploadIcon(Request $request)
    {
        $icon = Firebase::getInstance()->uploadFile($request->file('icon'), 'languages');

        $this->model->icon = $icon;
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
