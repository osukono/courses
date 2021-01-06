<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TopicCreateRequest;
use App\Http\Requests\Admin\TopicUpdateRequest;
use App\Library\Sidebar;
use App\Repositories\FirebaseTopicRepository;
use App\Repositories\TopicRepository;
use App\Topic;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Kreait\Firebase\Exception\RemoteConfigException;

class TopicController extends Controller
{
    public function __construct()
    {
        View::share('current', Sidebar::topics);
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $data['topics'] = TopicRepository::all()->ordered()->get();

        return view('admin.topics.index')->with($data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.topics.create');
    }

    /**
     * @param TopicCreateRequest $request
     * @return RedirectResponse
     * @throws RemoteConfigException
     */
    public function store(TopicCreateRequest $request)
    {
        try {
            $topic = TopicRepository::create($request->all());
            FirebaseTopicRepository::createOrUpdate($topic);
            FirebaseTopicRepository::incrementTopicsVersion();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.topics.index');
    }

    /**
     * @param Topic $topic
     * @return Factory|View
     */
    public function edit(Topic $topic)
    {
        $data['topic'] = $topic;

        return view('admin.topics.edit')->with($data);
    }

    /**
     * @param TopicUpdateRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     * @throws RemoteConfigException
     */
    public function update(TopicUpdateRequest $request, Topic $topic)
    {
        try {
            $topic->repository()->update($request->all());
            FirebaseTopicRepository::createOrUpdate($topic);
            FirebaseTopicRepository::incrementTopicsVersion();
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.topics.index');
    }

    /**
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function sync(Topic $topic)
    {
        try {
            FirebaseTopicRepository::createOrUpdate($topic);
            FirebaseTopicRepository::incrementTopicsVersion();
        } catch (Exception | RemoteConfigException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
