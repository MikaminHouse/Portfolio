using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class EnemyPointScript : MonoBehaviour
{
    [SerializeField] private int value;
    private float countDown;  //時間をカウントする変数
    private int timeLimit;  //時間制限を格納する変数
    private bool canMove;  //移動を開始する変数
    private GameObject target;
    private int beforePoint;  //地点に到達した時の数値を格納
    private void Update()
    {
        if (canMove)
        {
            countDown += Time.deltaTime;
            //Debug.Log(countDown);
            if (countDown > timeLimit)
            {
                while(target.GetComponent<EnemyController>().pointValue == beforePoint)
                {
                    target.GetComponent<EnemyController>().pointValue = Random.Range(0, target.GetComponent<EnemyController>().enemyPoint.Count);
                }
                //Debug.Log(other.GetComponent<EnemyController>().pointValue);
                countDown = 0;
                canMove = false;
            }

        }
    }
    private void OnTriggerEnter(Collider other)
    {
        if((other.tag == "Enemy" || other.tag == "Boss") && other.GetComponent<EnemyController>().pointValue == value)
        {
            //Debug.Log("OK");
            beforePoint = other.GetComponent<EnemyController>().pointValue;
            timeLimit = Random.Range(0, 10);
            canMove = true;
            target = other.gameObject;
        }
    }
}
