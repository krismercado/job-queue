<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
              <div class="title m-b-md">
                    Edit a job
                </div>
                <div class="lists">
                  <br>
                  <form method="POST" action="/tasks/{{ $task->id }}">
                    @method('patch')
                    @csrf
                    <!-- ^^ -->
                    <div class="field">
                      <p class="control">
                        <input class="input {{ $errors->has('title')? 'is-danger':'' }}" type="text" name="title" placeholder="Title"  value="{{ $task->title }}" required/>
                      </p>
                    </div>
                    <div class="field">
                      <p class="control">
                        <textarea class="textarea {{ $errors->has('description')? 'is-danger':'' }}" name="description" placeholder="Description" required>{{ $task->description }}</textarea>
                      </p>
                    </div>
                    <div class="field">
                      <p class="control">
                        <select name="priority" placeholder="Priority" value={{ $task->priority }} required>
                          <option value="3">High</option>
                          <option value="2">Medium</option>
                          <option value="1">Low</option>
                        </select>
                      </p>
                    </div>
                    <div class="field">
                      <p class="control">
                        <button class="button is-success">
                          Update Job
                        </button>
                      </p>
                    </div>

                    @if ($errors->any())
                    <div class="notification is-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                    @endif

                  </form>

                  <br />
                  @if(session()->has('message'))
                      <div class="alert alert-success">
                          <b>{{ session()->get('message') }}</b>
                      </div>
                  @endif
                </div>
            </div>
        </div>
    </body>
</html>
