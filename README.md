# foreup
- Test repo for some golf fun



    use jtx\foreup\Services\StandardGolfApi;
    $x = new StandardGolfApi();
    $y = $x->auth();
    $x->createUser($y, 1, ['username' => 'jimmy']);


or if you're lazy


    use jtx\foreup\Services\StandardGolfApi;
    $x = new StandardGolfApi();
    $x->createUserOneStep(1, ['username' => 'jimmy']);
