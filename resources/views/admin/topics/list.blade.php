<table class="table">
    <thead>
    <tr>
        <th class="col-12"></th>
        <th>Identifier</th>
        <th class="text-nowrap">Firestore ID</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($topics as $topic)
        <tr>
            <td class="text-nowrap">{{ $topic->name }}</td>
            <td>{{ $topic->identifier }}</td>
            <td>
                @if(isset($topic->firebase_id))
                    {{ $topic->firebase_id }}
                @else
                    <div class="text-center">
                        <a href="#" onclick="$('#topic-{{ $topic->id }}-sync').submit();">
                            <icon-refresh></icon-refresh>
                        </a>
                    </div>
                    <form class="d-none" id="topic-{{ $topic->id }}-sync"
                          action="{{ route('admin.topics.firestore.sync', $topic) }}" method="post" autocomplete="off">
                        @csrf
                    </form>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.topics.edit', $topic) }}">
                    <icon-edit></icon-edit>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
