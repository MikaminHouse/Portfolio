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
}
