using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.AI;
using UnityEngine.SceneManagement;
public class EnemyController : MonoBehaviour
{
    private NavMeshAgent nav;
    
    //  パラメーター  //
    public int walkSpeed = 3;  //徘徊時のスピード
    public int dashSpeed = 6;  //追跡時のスピード

    //  Walk関数  //
    public bool canWalk = true;  //true:Walk関数が実行されている　false:Walk関数が実行されていない
    public List<GameObject> enemyPoint = new List<GameObject>();   //徘徊地点
    public int pointValue;  //徘徊地点を指定する変数

    //  Door関数  //
    private DoorController doorController;  //ドアのスクリプトを格納
    private LockController lockController;  //鍵付きドアのスクリプトを格納
    private bool stopFlag;  //敵の速度を0にして停止させる
    public bool canDoor;  //ture:DoorMoveを実行可能　false:DoorMoveを実行不可能
    private float countDwon;  //時間計測関数

    /*
    private NavMeshAgent nav;  //AI Naigationを格納
    private Animator anime;

    //  徘徊変数  //
    //徘徊する地点を格納
    public List<GameObject> enemyPoint = new List<GameObject>();
    //徘徊する地点を指定する変数
    public int pointValue;

    public bool canWalk;
    private bool canDoor;
    private float countDown;

    public int hitPoint;  //Colonyの敵のみの要素

    */

    private void Start()
    {
        nav = GetComponent<NavMeshAgent>();

        pointValue = Random.Range(0, enemyPoint.Count);  //地点をランダムで選出
    }
    private void Update()
    {
        if (canWalk) Walk();
        Door();
    }
    public void Walk()  //徘徊関数
    {
        nav.speed = walkSpeed;  //移動する速さを設定
        //地点の位置を取得
        Vector3 targetPoint = enemyPoint[pointValue].transform.position;
        //地点に向かって移動する
        nav.destination = new Vector3(targetPoint.x, targetPoint.y, targetPoint.z);
    }
    public void Dash(GameObject target)
    {
        nav.speed = dashSpeed;  //移動する早さを設定
        //プレイヤーに向かって移動する
        nav.destination = target.transform.position;

    }
    public void Door()  //ドア関数
    {
        //ドアに対する処理
        Vector3 MoveForward = Vector3.Scale(transform.forward, new Vector3(1, 1, 1)).normalized;  //前方を取得
        Ray enemyRay = new Ray(transform.position + new Vector3(0, 2, 0), MoveForward);  //Rayを発生
        //Debug.DrawRay(enemyRay.origin, enemyRay.direction * 3f, Color.red, 3);  //Rayを可視化
        RaycastHit enemyHit;
        Physics.Raycast(enemyRay, out enemyHit, 2f);  //Rayに判定を付与
        if(enemyHit.collider != null)
        {
            if(enemyHit.collider.tag == "Door")
            {
                doorController = enemyHit.collider.GetComponent<DoorController>();  //ドアのスクリプトを取得
                if (doorController.lockType == false) pointValue = Random.Range(0, enemyPoint.Count);
                else if (doorController.lockType && stopFlag == false)
                {
                    //doorController.doorMove = true;
                    doorController.canF = true;
                    doorController.DoorMove();
                    stopFlag = true;
                }
            }
            if(enemyHit.collider.tag == "Lock")
            {
                lockController = enemyHit.collider.GetComponent<LockController>();  //鍵付きドアのスクリプトを取得
                if (lockController.lockType == false) pointValue = Random.Range(0, enemyPoint.Count);
                else if (lockController.lockType && canDoor)
                {
                    doorController.canF = true;
                    //lockController.doorMove = true;
                    lockController.DoorMove();
                    stopFlag = true;
                }
            }
        }
        if (stopFlag)
        {
            nav.speed = 0;  //移動速度を0に
            countDwon += Time.deltaTime;  //時間計測開始
            if(countDwon > 3)  //3秒後に移動開始
            {
                nav.speed = walkSpeed;
                countDwon = 0;
                if (doorController) doorController.canF = false;
                if (lockController) lockController.canF = false;
                stopFlag = false;
            }
        }
        

    }
    private void OnTriggerEnter(Collider other)
    {
        if(other.tag == "Player")
        {
            other.GetComponent<PlayerController>().lifeSlider.value = 0;
        }
    }
    /*
    private void Start()
    {
        if (gameObject.tag == "Boss"  || gameObject.tag == "Colony") anime = GetComponent<Animator>();
        nav = GetComponent<NavMeshAgent>();
        canWalk = true;
        nav.speed = walkSpeed;  //移動スピードを徘徊時のスピードにする
        pointValue = Random.Range(0, enemyPoint.Count);  //地点をランダムで選出
    }
    private void Update()
    {
        if (canWalk)
        {
            if (gameObject.tag == "Boss")
            {
                anime.SetFloat("Dash", 1);
                anime.SetBool("Walk", true);
            }
            Walk();
        }
        if(gameObject.tag == "Colony")
        {
            int num = Random.Range(0, 10) + 1;
            if (num < 5) anime.SetBool("Jump", true);
            else anime.SetBool("Jump", false);
            if (hitPoint == 20) Destroy(gameObject);

        }
    }
    public void Walk()  //徘徊関数
    {
        nav.speed = walkSpeed;
        if(gameObject.tag == "Enemy")
        {
            //地点の位置を取得
            Vector3 targetPoint = enemyPoint[pointValue].transform.position;
            //地点に向かって移動する
            nav.destination = new Vector3(targetPoint.x, targetPoint.y, targetPoint.z);

        }

        //ドアに対する処理
        Vector3 MoveForward = Vector3.Scale(transform.forward, new Vector3(1, 1, 1)).normalized;
        Ray enemyRay = new Ray(transform.position + new Vector3(0, 2, 0), MoveForward);
        //Debug.DrawRay(enemyRay.origin, enemyRay.direction * 3f, Color.red, 3);
        RaycastHit enemyHit;
        Physics.Raycast(enemyRay, out enemyHit, 3f);
        if(enemyHit.collider != null && (enemyHit.collider.tag == "Door" || enemyHit.collider.tag == "Lock"))
        {
            if(enemyHit.collider.tag == "Door") doorController = enemyHit.collider.GetComponent<DoorController>();  //ドアのスクリプトを取得
            if(enemyHit.collider.tag == "Lock") lockController = enemyHit.collider.GetComponent<LockController>();  //鍵付きドアのスクリプトを取得
            //  ドアに鍵がかかっていたら別の場所に移動
            if (doorController.lockType == false || lockController.lockType == false) pointValue = Random.Range(0, enemyPoint.Count);
            //  ドアに鍵がかかっていなかったときの処理
            else if(doorController.lockType || lockController.lockType)
            {
                nav.speed = 0;  //移動速度を0にする
                countDown += Time.deltaTime;  //時間計測
                //3秒後にドアを開ける
                if(countDown > 3)
                {
                    //ドアを開ける処理
                    if (doorController.doorMove == false)
                    {
                        doorController.doorMove = true;
                        doorController.DoorMove();
                    }
                    //鍵付きドアを開ける処理
                    if (lockController.doorMove == false)
                    {
                        lockController.doorMove = true;
                        lockController.DoorMove();
                    }
                    nav.speed = walkSpeed;
                }
            }
            //  ドアが閉じていたら少し止まってドアを開けてから移動
        }



















        /*
        if (enemyHit.collider != null && enemyHit.collider.tag == "Door" && enemyHit.collider.GetComponent<DoorController>().doorMove == false)
        {
            nav.speed = 0;
            countDown += Time.deltaTime;
            if (countDown > 3)
            {
                nav.speed = walkSpeed;
                enemyHit.collider.GetComponent<DoorController>().DoorMove();
            }
        }

        if (enemyHit.collider != null && enemyHit.collider.tag == "Lock")
        {
            if (enemyHit.collider.GetComponent<LockController>().lockType == false)
            {
                pointValue = Random.Range(0, enemyPoint.Count);
            }
            else
            {
                enemyHit.collider.GetComponent<LockController>().DoorMove();
            }

        }
    }
    public void Dash(GameObject target)  
    {
        if(gameObject.tag == "Boss")
        {
            anime.SetFloat("Dash", 10);
        }
        nav.destination = target.transform.position;
        nav.speed = dashSpeed;
    }
    private void OnTriggerEnter(Collider other)
    {
        if(other.tag == "Player")
        {
            if (gameObject.tag == "Enemy") other.GetComponent<PlayerController>().lifeSlider.value = 0;
            else if (gameObject.tag == "Colony")
            {
                other.GetComponent<PlayerController>().lifeSlider.value -= 5;
                other.GetComponent<Rigidbody>().AddForce(transform.forward * -2, ForceMode.Impulse);
            }
            else if(gameObject.tag == "Boss")
            {
                other.GetComponent<PlayerController>().lifeSlider.value -= 10;
            }

        }
    }



    /*
    [SerializeField] private int walkSpeed = 5;  //徘徊時のスピード
    [SerializeField] private int dashSpeed = 10;  //追跡時のスピード
    [SerializeField] private float searchAngle = 130f;  //視界の範囲
    private NavMeshAgent nav;  //AI Navigationを格納
    private Ray slopeRay;
    private float getSlope;

    //EnemyWalk関数//
    private bool canWalk;
    public int countDown;
    public int pointValue;
    //徘徊する地点を格納
    public List<GameObject> pointList = new List<GameObject>();

    //Bossのアニメーション//
    private Animator anime;


    private void Start()
    {
        nav = GetComponent<NavMeshAgent>();
        canWalk = true;
        //ポイントを指定する整数をランダムで算出
        pointValue = Random.Range(0, pointList.Count);
        if(gameObject.tag == "Boss")
        {
            anime = GetComponent<Animator>();
        }
    }
    private void Update()
    {
        Vector3 MoveForward = Vector3.Scale(transform.forward, new Vector3(1, 1, 1)).normalized;
        Ray enemyRay = new Ray(transform.position + new Vector3(0, -1, 0), MoveForward);
        //Debug.DrawRay(enemyRay.origin, enemyRay.direction * 3.5f, Color.red, 100);
        RaycastHit enemyHit;
        Physics.Raycast(enemyRay, out enemyHit, 10f);
        if (enemyHit.collider.tag == "Door")
        {
            enemyHit.collider.GetComponent<DoorController>().DoorMove();
        }
        if(enemyHit.collider.tag == "Rock Door")
        {
            if(enemyHit.collider.GetComponent<RockDoorController>().rockType == 0)
            {
                pointValue = Random.Range(0, pointList.Count);
            }
            else
            {
                enemyHit.collider.GetComponent<RockDoorController>().DoorMove();
            }
            
        }
        if (canWalk) EnemyWalk();
    }
    public void EnemyWalk()  //徘徊関数
    {
        anime.SetBool("Walk", true);
        slopeRay = new Ray(transform.position, Vector3.down);
        RaycastHit slopeHit;
        Physics.Raycast(slopeRay, out slopeHit, 2.5f);  //()の第一引数にRayの名前、第二引数に情報を入れる変数名、第三引数にRayの長さ　　　※「out」を付けることでhitに戻り値を取得できる
        getSlope = Vector3.Angle(Vector3.up, slopeHit.normal);
        if (getSlope > 0)
        {
            nav.speed = walkSpeed / 2;
        }
        else if(getSlope == 0)
        {
            nav.speed = walkSpeed;
        }

        //時間を計測
        countDown += 1;
        if (countDown % 1800 == 0)
        {
            //ポイントを指定する整数をランダムで算出
            pointValue = Random.Range(0, pointList.Count);
        }
        //ポイントの位置を取得
        Vector3 targetPoint = pointList[pointValue].transform.position;
        //ポイントが指定されている場合に実行される
        if (pointList.Count > 0) nav.destination = new Vector3(targetPoint.x, targetPoint.y, targetPoint.z);

    }
    private void OnTriggerStay(Collider other)
    {
        if (other.tag == "Player")
        {
            anime.SetBool("Attack1", true);
            //　主人公の方向
            var playerDirection = other.transform.position - transform.position;
            //　敵の前方からの主人公の方向
            var enemyAngle = Vector3.Angle(transform.forward, playerDirection);
            //　サーチする角度内だったら発見
            if (enemyAngle <= searchAngle)
            {
                //プレイヤーの方向を向く
                Quaternion lookRotation = Quaternion.LookRotation(other.transform.position - transform.position, Vector3.up);
                lookRotation.z = 0;
                lookRotation.x = 0;
                transform.rotation = Quaternion.Lerp(transform.rotation, lookRotation, 0.05f);
                if (getSlope > 0)
                {
                    nav.speed = walkSpeed / 1.5f;
                }
                else if(getSlope == 0)
                {
                    nav.speed = dashSpeed;
                }
                nav.destination = other.transform.position;
            }
        }
    }
    private void OnTriggerEnter(Collider other)
    {
        if (other.tag == "Player")
        {
            //　主人公の方向
            var playerDirection = other.transform.position - transform.position;
            //　敵の前方からの主人公の方向
            var enemyAngle = Vector3.Angle(transform.forward, playerDirection);
            //　サーチする角度内だったら発見
            if (enemyAngle <= searchAngle)
            {
                canWalk = false;
                Camera.main.GetComponent<CameraController>().searchAudio.Stop();
                Camera.main.GetComponent<CameraController>().runAudio.Play();
            }
        }
    }
    private void OnTriggerExit(Collider other)
    {
        anime.SetBool("Attack1", false);
        if(other.tag == "Player")
        {
            //　主人公の方向
            var playerDirection = other.transform.position - transform.position;
            //　敵の前方からの主人公の方向
            var enemyAngle = Vector3.Angle(transform.forward, playerDirection);
            //　サーチする角度内だったら発見
            if (enemyAngle <= searchAngle)
            {
                canWalk = true;
                Camera.main.GetComponent<CameraController>().runAudio.Stop();
                Camera.main.GetComponent<CameraController>().searchAudio.Play();
            }

        }
    }


    
    private Ray enemyRay;
    //プレイヤーを格納
    public GameObject target;
    //徘徊するポイントを格納
    public List<GameObject> pointList = new List<GameObject>();
    private int value;
    private float countDown;
    private int trun;
    //敵の追跡方法を指定
    private int enemyType;

    // Start is called before the first frame update
    void Start()
    {
        //ポイントを指定する整数をランダムで算出
        value = Random.Range(0, pointList.Count);
        nav = GetComponent<NavMeshAgent>();
    }

    // Update is called once per frame
    void Update()
    {
        //EnemyChase();
        //if(trun == 0) EnemyMove();
    }
    public void EnemyChase()  //追跡コード
    {
        Vector3 MoveForward = Vector3.Scale(transform.forward, new Vector3(1, 1, 1)).normalized;
        enemyRay = new Ray(transform.position + new Vector3(0, -1, 0), MoveForward);
        //Debug.DrawRay(enemyRay.origin, enemyRay.direction * 3.5f, Color.red, 100);
        RaycastHit enemyHit;
        Physics.Raycast(enemyRay, out enemyHit, 10f);
        if(enemyHit.collider.tag == "Player")
        {
            nav.destination = enemyHit.collider.transform.position;
        }
        if (enemyHit.collider.tag == "Door")
        {
            enemyHit.collider.GetComponent<DoorController>().DoorMove();
        }
    }

    //一定範囲内にプレイヤーがいるとプレイヤーの方に向く
    private void OnTriggerStay(Collider other)
    {
        if (other.tag == "Player")
        {
            nav.speed = chaseSpeed;
            trun = 1;
            Quaternion lookRotation = Quaternion.LookRotation(target.transform.position - transform.position, Vector3.up);
            lookRotation.z = 0;
            lookRotation.x = 0;
            transform.rotation = Quaternion.Lerp(transform.rotation, lookRotation, 0.05f);
            //nav.destination = other.transform.position;

        }
        
        if(other.tag == "Door")
        {
            trun = 2;
            other.GetComponent<DoorController>().DoorMove();
            trun = 0;
        }
        
    }

    private void OnTriggerExit(Collider other)
    {
        if(other.tag == "Player") trun = 0;

    }
    */
}
