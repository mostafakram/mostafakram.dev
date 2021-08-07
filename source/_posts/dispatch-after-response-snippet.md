---
extends: _layouts.post
section: content
title: Test Dispatch After Response
date: 2021-08-07
featured: false
description: How to test dispatchAfterResponse
categories: [snippets, laravel]
---

If your code calls `dipatch(SomeAwesomeJob::class)->afterResponse()` instead of just `dispatch(SomeAwesomeJob::class)` to delay dispatching the job until after the HTTP response is sent to the user's browser here is how to test it in PHPUnit

```php
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendNotification;

/** @test */
public function job_dispatched_after_response()
{
   Bus::fake();
   
   // Call the code that fire the dispatchAfterResponse method
   
   Bus::assertDispatchedAfterResponse(SendNotification::class); 
   
}
```
- Use `Bus::fake()` instead of `Queue::fake()`
- Call `Bus::assertDispatchedAfterResponse()` with the job that should have been dispatched 


### References
- [Laravel Docs](https://laravel.com/docs/8.x/queues#dispatching-after-the-response-is-sent-to-browser) for dispatchAfterResponse
- [Pull request](https://github.com/laravel/framework/pull/31418) on laravel/framework by [Fabian Bettag](https://github.com/Jigsaw5279)